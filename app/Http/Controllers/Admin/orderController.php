<?php

namespace App\Http\Controllers\Admin;

use App\Mail\OrderMail;
use App\Models\DetailsOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class orderController extends Controller
{

    private $order;

    public function __construct()
    {
        $this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index','notSent','show']]);
//        $this->middleware('permission:order-create', ['only' => ['create','store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy','detailDestroy','status']]);
        
        $this->order = new Order();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->order->with(['address','giftCard','users'])->paginate(5);
        return view('admin.orders.index',compact('orders'));
    }

    /**
     * Display a new orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function notSent()
    {
        $orders = $this->order->where('order_status',0)->with(['address','giftCard','users'])->paginate(5);
        return view('admin.orders.index',compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (ctype_digit($id)){
            $order = $this->order->with(['address','giftCard','users','detailsOrder'])->where('order_id',$id)->first();
            return view('admin.orders.show',compact('order'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (ctype_digit($id)){
            $order = $this->order->findOrFail($id);
            $order->detailsOrder()->delete();
            $order->delete();
            return $order
                ? response()->json(['success' => $order])
                : response()->json(['error' => 'error']);
        }
    }

    public function detailDestroy($id)
    {
        if (ctype_digit($id)){
            $d_order = DetailsOrder::findOrFail($id);
            $d_order->delete();
            return $d_order
                ? response()->json(['success' => $d_order])
                : response()->json(['error' => 'error']);

        }
    }

    public function status($id,$status)
    {
        if (ctype_digit($id)){
            $order = $this->order->findOrFail($id);
            $email = $order->client_email;
            if ($status == 'sent'){
                $s = $order->update(['order_status' => 2]);
                $order = ['code' => "$order->track_code" , 'status' => 'sent '];
            }elseif($status == 'delivered'){
                $s = $order->update(['order_status' => 3]);
                $order = ['code' => "$order->track_code" , 'status' => 'posted'];
            }
            Mail::to($email)->send(new OrderMail($order));
            return $s
                ? response()->json(['success' => $order])
                : response()->json(['error' => 'error']);

        }
    }
}
