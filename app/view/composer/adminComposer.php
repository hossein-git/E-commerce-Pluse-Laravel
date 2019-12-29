<?php

namespace App\view\composer;


use App\Models\brand;
use App\Models\Category;
use App\Models\GiftCard;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Laravelista\Comments\Comment;

class adminComposer
{

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with([
            'categories' => Category::whereIsRoot()->with('children')->get(['category_name', 'category_id']),
        ]);

    }

    /**
     * uses on sub menu in admin panel
     * @param View $view
     */
    public function menuCount(View $view)
    {
        $menu_count = Cache::remember('menu_count',1440, function () {
            return $menu_count = [
                'orders' => Order::count(),
                'payments' => Payment::count(),
                'comments' => Comment::count(),
                'users' => User::count(),
                'products' => Product::count(),
                'categories_count' => Category::count(),
                'brands' => brand::count(),
                'gift_cards' => GiftCard::count(),
            ];
        });
        $view->with([
            'menu_count' => $menu_count
        ]);
    }

}