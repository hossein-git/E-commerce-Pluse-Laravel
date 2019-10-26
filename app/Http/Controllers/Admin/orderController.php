<?php

namespace App\Http\Controllers\Admin;

use App\Models\DetailsOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class orderController extends Controller
{

    private $order;

    public function __construct()
    {
        $this->order = new Order();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->order->paginate(5);
        return view('admin.orders.index',compact('orders'));
    }

    public function notSent()
    {
        $orders = $this->order->where('order_status',0)->paginate(5);
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
            $detailsOrder = $this->order->findOrFail($id)->detailsOrder;
            return view('admin.orders.show',compact('detailsOrder'));
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
            if ($order){
                return response()->json(['success' => $order]);
            }
            return response()->json(['error' => 'error']);
        }
    }

    public function detailDestroy($id)
    {
        if (ctype_digit($id)){
            $d_order = DetailsOrder::findOrFail($id);
            $d_order->delete();
            if ($d_order){
                return response()->json(['success' => $d_order]);
            }
            return response()->json(['error' => 'error']);
        }
    }

    public function status($id,$status)
    {
        if (ctype_digit($id)){
            $order = $this->order->findOrFail($id);
            if ($status == 'sent'){
                $s = $order->update(['order_status' => 2]);
            }elseif($status == 'delivered'){
                $s = $order->update(['order_status' => 3]);
            }
            if ($s){
                return response()->json(['success' => $order]);
            }
            return response()->json(['error' => 'error']);
        }
    }
}
