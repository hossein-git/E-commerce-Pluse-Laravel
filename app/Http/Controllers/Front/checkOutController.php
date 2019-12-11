<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests\addressRequest;
use App\Models\Address;
use App\Models\CheckGift;
use App\Models\GiftCard;
use App\Models\Order;
use App\User;
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
        return view('Front.account.checkout');
    }

    public function interCheckOut()
    {
        return view('Front.account.before_CH');
    }

    //save order
    public function store(Request $request)
    {
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
        $input['user_id'] = $this->user_id;
        //set a gift amount , if exist  then it will change
        $giftAmount = 0;
        //IF USER HAS APPLIED GIFT CARD
        if ($request->session()->has('gift_id')) {
            $input['gift_id'] = $request->session()->pull('gift_id');
            $giftAmount = GiftCard::findOrFail($input['gift_id'])->get(['gift_amount']);
            session(['gift_price' => $giftAmount]);
        }
        //GENERATE 8 N CODE
        $input['track_code'] = random_int(10000000, 99999999);
        //delete last '.00' and ',' char from subTotal
        $input['total_price'] = substr(str_replace(',', '', Cart::total()), 0, -3) - $giftAmount;
        $order = Order::create($input);
        session(['order_id' => $order->order_id]);
        return response()->json(['success' => 'ok']);
    }

    //save address
    public function saveAddress(Request $request)
    {
        $input = $request->except('_token');

        $input['addressable_id'] = session('order_id');
        $input['addressable_type'] = Order::class;

        //IF USER SAVE IT AS DEFAULT ADDRESS
        if (isset($input['def_addr']) and $input['def_addr'] == "true") {
            $input['addressable_id'] = $this->user_id;
            $input['addressable_type'] = User::class;
        }

        Address::create($input);
        return response()->json(['success' => 'ok']);

    }


    public function saveOrderStatus()
    {
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
        //change order status
        $this->order->findOrFail(session('order_id'))->update(['status' => 1 ]);

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
            return back(['error' => 'only numbers and letters']);
        }
        $input = strtolower($request->giftCode);

        // TAKE A ACTIVE ROW WHERE gift_code MATCHES
        $code = GiftCard::whereStatusAndGift_code(1, $input)->pluck('gift_id');
        if ($code->count() == 0) {
            return response()->json(['success' => 'false']);
        }

        //IF THIS ROW EXIST IT MEANS USER HAS USE THIS CODE
        $gift_code = CheckGift::whereUser_idAndGift_id($this->user_id, $code[0])->count();
        if ($gift_code > 0) {
            return response()->json(['success' => 'repeat']);
        }

        //SAVE ORDER_ID TO USE IT TO SAVE ADDRESS , ORDER_DETAILS AND PAYMENTS
        session(['gift_id' => $code[0]]);
        return response()->json(['success' => 'true']);

    }


}
