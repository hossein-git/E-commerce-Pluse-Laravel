<?php

namespace App\Http\Controllers\Admin;

use App\Models\DetailsOrder;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    private $order;
    private $product;
    private $payment;


    public function __construct()
    {
        $this->middleware('checkRole');
        $this->middleware('permission:see-dashboard', ['only' => ['index']]);
        $this->order = new Order();
        $this->product = new Product();
        $this->payment = new Payment();
    }

    /**
     * admin dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $date = Carbon::today()->subDays(7);

        /*---------------orders------------------*/
        $order_sent = $this->order->where('order_status', 2)->count();
//        $order_delivered = $this->order->where('order_status', 3)->count();
        $order_news = $this->order->where('order_status', '=', 1)->count();
        $order_not_complete = $this->order->where('order_status', '=', 0)->count();
        /*---------------payments------------------*/
        $payment_week =  $this->payment->where('created_at','>',$date)->count();
        $payment_success =  $this->payment->where('status',1)->count();
        $payment_failed =  $this->payment->where('status',1)->count();


        /*---------------users------------------*/
        $employees = DB::table('user_has_roles')->count();
        $new_users = User::where('created_at', '>=', $date)->count();
        /*---------------Products------------------*/

        $discounted_products = $this->product->where('is_off', 1)->count();
        $available_products = $this->product->where('status', 1)->count();
        $product_news = $this->product->where('created_at', '>=', $date)->count();
        //calculate Product availability percentage
//        $all_pr = \cache('menu_count')['products'];
//        $percantage = ((($all_pr - $available_products) * 100 ) / $all_pr);
//        $Product_availability = number_format((float)$percantage , 2 , '.' ,'');

        /*--------------- Popular Products:------------------*/
        $popular_product = DetailsOrder::select('product_id')->orderBy('product_id', 'desc')->distinct()->pluck('product_id')->take(5);
        $popular_products = $this->product->findOrFail($popular_product,
            ['status', 'product_id', 'product_name', 'sale_price', 'off_price', 'is_off']);

        return view('admin.dashboard.dashboard', compact(
            'discounted_products', 'available_products', 'product_news', 'new_users', 'employees',
            'order_news', 'order_sent', 'order_not_complete', 'popular_products','payment_failed','payment_success','payment_week'));
    }

    /**
     * search in admin
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function search(Request $request)
    {
        $this->validate($request, [
            'search_kind' => 'required',
            'search' => 'string|nullable'
        ]);
        if ($request->search_kind == 'orders') {
            $orders = $this->order
                ->Where('track_code', 'like', '%' . $request->search)->paginate(10);
            $view = view('admin.orders._data', compact('orders'))->render();

        } else {
            $products = $this->product
                ->Where('product_name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', $request->search)
                ->paginate(10);
            $index_categories = true;
            $view = view('admin.products._data', compact('products', 'index_categories'))->render();
        }

        if ($request->ajax()) {
            return response()->json(['html' => $view]);
        }

    }
}
