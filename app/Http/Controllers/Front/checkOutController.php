<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class checkOutController extends Controller
{
    private $order;

    public function __construct()
    {
        $this->order = new Order;
    }
    
    public function index()
    {
        return view('Front.account.checkout');
    }


    public function store(Request $request)
    {
        $input = $request->except('_token');

    }
}
