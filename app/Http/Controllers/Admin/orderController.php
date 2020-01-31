<?php

namespace App\Http\Controllers\Admin;

use App\Mail\OrderMail;
use App\Models\DetailsOrder;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class orderController extends Controller
{

    private $order;
    /**
     * @var OrderRepository
     */
    private $orderRepo;

    public function __construct(OrderRepository $repository)
    {
        $this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index', 'notSent', 'show']]);
//        $this->middleware('permission:order-create', ['only' => ['create','store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy', 'detailDestroy', 'status']]);

        $this->order = new Order();
        $this->orderRepo = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Cache::has('orders')) {
            $orders = Cache::get('orders');
        } else {
            $orders = $this->order->with(['address', 'giftCard', 'users', 'payment'])->paginate(15);
        }
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display a new orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function notSent()
    {
        $orders = $this->order->where('order_status', 0)->with(['address', 'giftCard', 'users', 'payment'])->paginate(5);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->orderRepo->checkId($id);
        $order = $this->order->with(['address', 'payment', 'giftCard', 'users', 'detailsOrder'])->where('order_id', $id)->first();
        return view('admin.orders.show', compact('order'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $order = $this->orderRepo->destroy($id);
        return $this->orderRepo->passViewAfterDeleted($order, 'orders');
    }

    /**
     * @param $id
     * @return Response
     */
    public function detailDestroy($id)
    {
        $this->orderRepo->checkId($id);
        $d_order = DetailsOrder::findOrFail($id)->delete();
        return $this->orderRepo->passViewAfterDeleted($d_order, 'detailsOrders');

    }

    public function status($id, $status)
    {
        $order = $this->orderRepo->find($id);
        $email = $order->client_email;
        if ($status == 'sent') {
            $editedOrder = $order->update(['order_status' => 2]);
            $order = ['code' => "$order->track_code", 'status' => 'sent '];
        } elseif ($status == 'delivered') {
            $editedOrder = $order->update(['order_status' => 3]);
            $order = ['code' => "$order->track_code", 'status' => 'posted'];
        }
        //should be on jobs
//        Mail::to($email)->send(new OrderMail($order));
        if (!isset($editedOrder)) {
            $editedOrder = false;
        }
        return $this->orderRepo->passResponse($editedOrder, 'orders', 'status');

    }
}
