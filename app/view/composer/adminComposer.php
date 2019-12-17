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
use Laravelista\Comments\Comment;

class adminComposer
{

    public function compose(View $view)
    {
        $view->with([
            'categories' => Category::whereIsRoot()->with('children')->get(['category_name','category_id']),
        ]);
    }
    /*---------------uses on sub menu ------------------*/
    public function menuCount(View $view)
    {
        $view->with([
            'menu_count'  =>[
                'orders' => Order::count(),
                'payments' => Payment::count(),
                'comments' => Comment::count(),
                'users' => User::count(),
                'products' => Product::count(),
                'categories_count' => Category::count(),
                'brands' => brand::count(),
                'gift_cards' => GiftCard::count(),
            ],
        ]);
    }

}