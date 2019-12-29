<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\addressRequest;
use App\Models\Order;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;

class accountController extends Controller
{
    private $user;
    private $order;

    public function __construct()
    {
        $this->middleware('auth');
        $this->user = new User();
        $this->order = new Order();
    }

    /**
     *  show profile page.
     *
     * @return view
     */
    public function profile()
    {
        $user = $this->user->findOrFail(auth()->id());
        $address = $user->address;
        return view('Front.account.profilePanel', compact('user', 'address'));
    }

    /**
     *  show orders of user.
     *
     * @return view
     */
    public function myOrders()
    {
        $user = $this->user->findOrFail(auth()->id());
        $orders = $user->orders;
        return view('Front.account.myOrders', compact('orders'));
    }

    /**
     * show invoice
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showOrder($id)
    {
        if (ctype_digit($id)){
            $order = $this->order->with(['address','giftCard','users','detailsOrder'])->where('order_id',$id)->first();
            $this->checkOrderUserId($order->user_id);
            return view('Front.account.show_order',compact('order'));
        }
    }

    /**
     *  show edit user Address page.
     *
     * @return view
     */
    public function editAddress()
    {
        $address = $this->user->findOrFail(auth()->id())->address;
        return view('Front.account.editAddress', compact('address'));
    }

    /**
     *  show edit page order Address.
     *
     * @param int $id
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function editOrderAddress($id)
    {
        if (ctype_digit($id)) {
            $order = $this->order->findOrFail($id, ['order_id', 'user_id']);
            //check that the order is own to auth user
            $this->checkOrderUserId($order->user_id);
            $address = $order->address;
            $order_id = $order->order_id;
            return view('Front.account.editAddress', compact('address', 'order_id'));
        }
    }

    /**
     *  updating user Address and order address.
     *
     * @param addressRequest $request
     * @return \Illuminate\Http\Response
     */
    public function updateAddress(addressRequest $request)
    {

        if (ctype_digit($order_id = $request->input('order_id'))) {
            $order = $this->order->findOrFail($order_id, ['order_id', 'user_id']);
            $this->checkOrderUserId($order->user_id);
//                $order->address()->updateOrCreate($request->except('_token','_method'));
            //if order has address then update it if not create
            if ($order->address) {
                $order->address->fill($request->except('_token'))->save();
            } else {
                $order->address()->create($request->except('_token'));
            }
        } else {
            $user = $this->user->findOrFail(auth()->id());
            //if user has address update it if not create new
            if ($user->address) {
                $user->address->fill($request->except('_token'))->save();
            } else {
                $user->address()->create($request->except('_token'));
            }
        }

        return response()->json(['success' => 'ok']);

    }

    /**
     *  cancel order from user panel.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function cancelOrder(Request $request)
    {
        if (ctype_digit($id = $request->input('order_id'))) {
            $order = $this->order->findOrFail($id, ['order_id', 'user_id']);
            $this->checkOrderUserId($order->user_id);
            $order->update(['order_status' => 5]);
            return response()->json(['success' => 'ok']);
        }
    }

    /**
     * favorite post
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function favoritePost(Request $request)
    {
        if (ctype_digit($id = $request->input('id'))) {
            $product = Product::findOrFail($id);
            auth()->user()->favorites()->attach($product);
            return response()->json(['success' => 'true']);
        }
    }

    /**
     * un-favorite post
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function unFavoritePost(Request $request)
    {
        if (ctype_digit($id = $request->input('id'))) {
            $product = Product::findOrFail($id);
            auth()->user()->favorites()->detach($product);
            return response()->json(['success' => 'true']);
        }
    }

    /**
     * Get all favorite product for user
     *
     * @return Response
     */
    public function myFavorites()
    {
        $myFavorites = auth()->user()->favorites;
        return view('Front.account.myWishList', compact('myFavorites'));
    }

    /**
     *  check that the order is own to auth user
     *
     * @param int $user_id = $order->user_id
     * @return boolean
     */
    private function checkOrderUserId($user_id)
    {
        if ($user_id !== auth()->id()) {
            return response()->view('Front.errors.404');
        }
    }


}
