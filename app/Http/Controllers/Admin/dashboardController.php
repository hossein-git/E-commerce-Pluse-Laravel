<?php

namespace App\Http\Controllers\Admin;

use App\Models\DetailsOrder;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class dashboardController extends Controller
{
    private $order;
    private $product;
    private $payment;
    private $user;


    public function __construct()
    {
        $this->order = new Order();
        $this->product = new Product();

    }

    public function index()
    {



        /*---------------orders------------------*/

        $order_sent = $this->order->where('order_status',1)->count();
        $order_delivered = $this->order->where('order_status',2)->count();
        $order_news = $this->order->where('order_status','=',0)->count();
        /*---------------payments------------------*/
        
        /*---------------users------------------*/

        /*---------------Products------------------*/

        $discounted_products = $this->product->where('is_off',1)->count();
        $available_products = $this->product->where('status',1)->count();
        $date = Carbon::today()->subDays(7);
        $product_news = $this->product->where('created_at','>=',$date)->count();
        
        
        /*--------------- Popular Products:------------------*/
        $popular_product = DetailsOrder::select('product_id')->orderBy('product_id','desc')->distinct()->pluck('product_id')->take(5);
        $popular_products = $this->product->findOrFail($popular_product,
            ['status','product_id','product_name','sale_price','off_price','is_off']);
//        dd($popular_products);

        return view('admin.dashboard.dashboard',compact(
            'discounted_products','available_products','product_news',
            'order_news','order_sent','order_delivered','popular_products'));
    }

    public function search(Request $request)
    {
        $this->validate($request,[
            'search_kind' => 'required',
            'search' => 'string|nullable'
        ]);
        if ($request->search_kind == 'orders'){
            $orders = $this->order
                ->Where('track_code', $request->search )->paginate(10);
            $view = view('admin.orders._data',compact('orders'))->render();

        }else{
            $products = $this->product
                ->Where('product_name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', $request->search )
                ->paginate(10);
            $index_categories = true;
            $view = view('admin.products._data',compact('products','index_categories'))->render();
        }

        if ($request->ajax()){
            return response()->json(['html' => $view]);
        }


    }
}
