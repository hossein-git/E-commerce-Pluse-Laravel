<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests\addressRequest;
use App\Models\Address;
use App\Models\CheckGift;
use App\Models\GiftCard;
use App\Models\Order;
use App\User;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class checkOutController extends Controller
{
    private $order;
//    private $order_id;
    private $user_id;

    public function __construct()
    {
        $this->order = new Order;
        //SAVE USER_ID IF USER IS LOGED IN
        if (auth()->check()) {
            $this->user_id = auth()->user()->user_id;
        }

    }

    public function index()
    {
        //IF AUTH AND USER HAS SAVED ADDRESS THEN SHOW THEM IN THE FORM FIELD
        if (auth()->check()){
            $address = User::findOrFail(auth()->id())->address;
            if ($address){
               return view('Front.account.checkout',compact('address'));
            }
        }
        return view('Front.account.checkout');
    }

    public function interCheckOut()
    {
        return view('Front.account.before_CH');
    }

    //save order
    public function store(Request $request)
    {
        //this input must be empty and if not means filled it with bots
        if($request->input('input')){
            return false;
        }
        // ID CART IS EMPTY
        if (!Cart::count() > 0) {
            return response()->json(['success' => 'your card is empty']);
        }
        $this->validate($request, [
            'client_name' => 'string|required|regex:^[a-zA-Z]^',
            'client_phone' => 'string|required',
            'details' => 'string|nullable',
        ]);

        $input = $request->except('_token');
        $input['user_id'] = auth()->id();
        //set a gift amount , if exist  then it will change
        $giftAmount = 0;
        //IF USER HAS APPLIED GIFT CARD
        if (session()->has('gift_id')) {
            $input['gift_id'] = session()->pull('gift_id');
            $giftAmount = GiftCard::findOrFail($input['gift_id'],['gift_amount'])->gift_amount;
            session(['gift_price' => $giftAmount]);
        }
        //GENERATE 8 N CODE
        $input['track_code'] = random_int(10000000, 99999999);
        //delete last '.00' and ',' char from subTotal
        $input['total_price'] = substr(str_replace(',', '', Cart::total()), 0, -3) - $giftAmount;
        $order = Order::create($input);
        session()->put(['order_id' => $order->order_id ], Carbon::now()->addMinutes(5));
        return response()->json(['success' => 'ok']);
    }

    //save address
    public function saveAddress(Request $request)
    {
        //this input must be empy and if not means filled it with bots
        if($request->input('input')){
            return false;
        }
        $input = $request->except('_token');
        if (!session()->has('order_id')){
            return \response()->json(['error' => 'your session time has expired , pls try again']);
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


    public function saveOrderStatus()
    {

        if (!session()->has('order_id')){
            return \response()->json(['error' => 'your session time has expired , pls try again']);
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
                    'order_id' => $order_id
                ]
            );
        }
        $query = DB::table('details_orders')->insert($input);
        return $query
            ? response()->json(['success' => 'order status ok'])
            : response()->json(['error' => 'system not response']);

    }

    //save PAYMENTS
    public function savePayments(Request $request)
    {
        //this input must be empy and if not means filled it with bots
        if($request->input('input')){
            return false;
        }
        if (!session()->has('order_id')){
            return \response()->json(['error' => 'your session time has expired , pls try again']);
        }
        //SAVE GIFT ID AND USER_ID IN checkGIFT
        //----//
        //change order status
        $this->order->findOrFail(session()->pull('order_id'))->update(['status' => 1 ]);

    }

    //CHECK THE DISCOUNT CODE AND ALSO IF USER USED IT BEFORE
    public function checkDiscount(Request $request)
    {
        if (!$request->giftCode) {
            return response()->json(['success' => 'empty']);
        }

        $this->validate($request, [
            'giftCode' => 'string|required'
        ]);

        // ONLY LETTERS AND NUMBERS
        if (!ctype_alnum($request->giftCode)){
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

        //SAVE ORDER_ID TO USE IT TO SAVE ADDRESS , ORDER_DETAILS AND PAYMENTS
        session()->put('gift_id' , $code->gift_id,Carbon::now()->addMinutes(5));
        return response()->json(['success' => 'true']);

    }

}
