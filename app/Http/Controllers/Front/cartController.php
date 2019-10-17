<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class cartController extends Controller
{

    //show the shopping cart
    public function index()
    {
        return view('Front.account.cart');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $this->validate($request, [
            'id' => 'numeric',
            'slug' => 'string',
            'name' => 'string',
            'price' => 'string',
            'qty' => 'numeric',
            'src' => 'string',
            'size' => 'nullable|string',
            'color' => 'nullable|string'
        ]);
        $request->price = str_replace(',', '', $request->price);
        Cart::add(['id' => "$request->id", 'name' => "$request->name", 'qty' => $request->qty, 'price' => "$request->price",
            'options' => [
                'size' => "$request->size",
                'color' => "$request->color",
                'src' => "$request->src",
                'slug' => "$request->slug",
            ]
        ]);

        if ($request->ajax()) {
            $view = view('layout.front.partials._cart')->render();
            return response()->json(['html' => $view]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
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

    public function update(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'rowId' => 'required|string',
            'qty' => 'required|numeric'
        ]);
        Cart::update($request->rowId, [ 'qty' => $request->qty ]);
        return response()->json(['success' => 1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($rowId)
    {
        if (ctype_xdigit($rowId)) {
            Cart::remove($rowId);
            return response()->json(['success' => 1]);
        }
    }

    //USE TO CLEAR SHOPPING CART
    public function clear()
    {
        Cart::destroy();
    }
}
