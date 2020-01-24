<?php

namespace App\Http\Controllers\Front;

use App\Exceptions\SessionExpiredException;
use App\Http\Requests\addressRequest;
use App\Jobs\SendOrderEmailsJob;
use App\Mail\PaymentMail;
use App\Models\Address;
use App\Models\CheckGift;
use App\Models\GiftCard;
use App\Models\Order;
use App\User;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class checkOutController extends Controller
{
    private $order;
    private $user_id;

    public function __construct()
    {
        $this->middleware('web', ['except' => 'checkDiscount']);
        $this->middleware('auth', ['only' => 'checkDiscount']);

        $this->order = new Order;
        //SAVE USER_ID IF USER IS LOGED IN
        if (auth()->check()) {
            $this->user_id = auth()->user()->user_id;
        }

    }

    /**
     *  show check out from when auth is true
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkCart();
        //IF AUTH AND USER HAS SAVED ADDRESS THEN SHOW THEM IN THE FORM FIELD
        if (auth()->check()) {
            $address = User::findOrFail(auth()->id())->address;
            if ($address) {
                return view('Front.check-out.checkout', compact('address'));
            }
        }
        return view('Front.check-out.checkout');
    }

    /**
     *  show check out from when auth is false
     *
     * @return \Illuminate\Http\Response
     */
    public function interCheckOut()
    {
        $this->checkCart();
        return view('Front.check-out.before_CH');
    }

    /**
     * Store a newly created order.
     *
     * @param Request $request
     * @return bool|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //this input must be empty and if not means filled it with bots
        if ($request->input('input')) {
            return false;
        }
        $this->checkCart();
        $this->validate($request, [
            'client_name' => 'string|required|regex:^[a-zA-Z]^',
            'client_phone' => 'string|required',
            'client_email' => 'email|required',
            'details' => 'string|nullable',
        ]);

        $input = $request->except('_token');
        $input['user_id'] = auth()->id();
        //set a gift amount , if exist  then it will change
        $giftAmount = 0;
        //IF USER HAS APPLIED GIFT CARD
        if (session()->has('gift_id')) {
            $input['gift_id'] = session()->get('gift_id');
            $giftAmount = GiftCard::findOrFail($input['gift_id'], ['gift_amount'])->gift_amount;
        }
        session(['gift_price' => $giftAmount]);
        //GENERATE 8 N CODE
        $input['track_code'] = random_int(10000000, 99999999);
        //delete last '.00' and ',' char from subTotal
        $subTotal = (substr(str_replace(',', '', Cart::subtotal()), 0, -3));
        $input['total_price'] = $subTotal - $giftAmount;
        $order = Order::create($input);
        session()->put(['order_id' => $order->order_id], Carbon::now()->addMinutes(5));
        return response()->json(['success' => 'ok']);
    }

    /**
     * Store  address of order.
     *
     * @param App\Http\Requests\addressRequest $request
     * @return \Illuminate\Http\Response
     * @return boolean
     * @throws SessionExpiredException
     */
    public function saveAddress(addressRequest $request)
    {
        //this input must be empty and if not means filled it with bots
        if ($request->input('input')) {
            return false;
        }
        $input = $request->except('_token');
        if (!session()->has('order_id')) {
            throw new SessionExpiredException();
        }

        //IF USER SAVE IT AS DEFAULT ADDRESS
        if (isset($input['def_addr']) and $input['def_addr'] == "true") {
            $input['addressable_id'] = auth()->id();
            $input['addressable_type'] = User::class;
            Address::create($input);
        }

        $input['addressable_id'] = session('order_id');
        $input['addressable_type'] = Order::class;
        Address::create($input);

        return response()->json(['success' => 'ok']);

    }

    /**
     * save products in order_status table.
     *
     * @return \Illuminate\Http\Response
     * @throws SessionExpiredException
     */
    public function saveOrderStatus()
    {

        if (!session()->has('order_id')) {
            throw new SessionExpiredException();
        }
        $input = [];
        $order_id = session('order_id');
        //SAVE ALL ITEMS IN CART TO ONE ARRAY THEN PUT ALL OF THEM IN DATABASE
        foreach (Cart::content() as $cart) {
            array_push($input, [
                    'product_id' => $cart->id,
                    'product_slug' => $cart->options->slug,
                    'attributes' => $cart->options->attr,
                    'product_price' => $cart->price,
                    'quantity' => $cart->qty,
                    'size' => $cart->options->size,
                    'color' => $cart->options->color,
                    'order_id' => $order_id,
                    'created_at' => Carbon::now()
                ]
            );
        }
        $query = DB::table('details_orders')->insert($input);
        Cart::destroy();
        return $query
            ? response()->json(['success' => 'order status ok'])
            : response()->json(['error' => 'system not response']);

    }

    /**
     *  this method does not work because the process with be continue in payPalController
     * Store  address of order.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws SessionExpiredException
     */
    public function savePayments(Request $request)
    {
        //this input must be empy and if not means filled it with bots
        if ($request->input('input')) {
            return false;
        }
        if (!session()->has('order_id')) {
            throw new SessionExpiredException();
        }
        //SAVE GIFT ID AND USER_ID IN checkGIFT
        //----//
        $order = $this->order->findOrFail(session()->pull('order_id'));

        //send email
        $data = ['track' => $order->track_code,'name' => $order->client_name  ,'status' => '1'];
        SendOrderEmailsJob::dispatch($order->client_email,$data);


        //change order status
        $order->update(['status' => 1]);

    }

    /**
     * CHECK THE DISCOUNT CODE AND ALSO IF USER USED IT BEFORE
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkDiscount(Request $request)
    {
        if (!$request->giftCode) {
            return response()->json(['success' => 'empty']);
        }

        $this->validate($request, [
            'giftCode' => 'string|required'
        ]);

        // ONLY LETTERS AND NUMBERS
        if (!ctype_alnum($request->giftCode)) {
            return response()->json(['error' => 'only numbers and letters']);
        }
        $input = strtolower($request->giftCode);

        // TAKE A ACTIVE ROW WHERE gift_code MATCHES
        $code = GiftCard::whereStatusAndGift_code(1, $input)->first('gift_id');
        if (!$code) {
            return response()->json(['success' => 'false']);
        }

        //IF THIS ROW EXIST IT MEANS USER HAS USE THIS CODE BEFORE
        $gift_code = CheckGift::whereUser_idAndGift_id(auth()->id(), $code->gift_id)->count();
        if ($gift_code > 0) {
            return response()->json(['success' => 'repeat']);
        }

        //SAVE GIFT_ID TO USE IT TO SAVE ORDERS AND SHOW ITS AMOUNT IN VIEW
        session()->put('gift_id', $code->gift_id, Carbon::now()->addMinutes(5));
        return response()->json(['success' => 'true']);

    }

    /**
     * if cart is empty show error page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkCart()
    {
        if (Cart::count() === 0) {
            return Redirect::route('cart.empty')->send();
        }
    }


}
