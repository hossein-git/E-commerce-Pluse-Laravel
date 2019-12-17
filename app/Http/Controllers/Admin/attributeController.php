<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Attribute_Value;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class attributeController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }


    /**
     * Show the form for creating a new attr.
     *
     * @return view
     */
    public function create()
    {
        $products = Product::select(['product_id', 'product_name'])->get();
        return view('admin.attributes.create', compact('products'));
    }

    /**
     * Show the form for creating a new attr from product show.
     * @param int $id
     * @return view
     */
    public function createNew($id)
    {
        $product = \App\Models\Product::findOrFail($id,['product_id','product_name']);
        return view('admin.attributes.create',compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|numeric',
            'attr_name' => 'required',
            'value' => 'required'
        ]);
        $values = [];

        //with array_filter null values will deleted
        foreach (array_filter($request->input('value')) as $value) {
            array_push($values, [
                'value' => $value
            ]);
        }
        $product = Product::findOrFail($request->input('product_id'), 'product_id');

//        $attribute = Attribute::create(['attr_name' => $request->input('attr_name')]);
        $attribute = $product->attributes()->create(['attr_name' => $request->input('attr_name')]);

        $attribute->attributeValues()->createMany($values);
//        $product->attributeValues()->attach($id_values);

        return redirect()->back()->with(['success' => 'new attribute has created and attached successfully']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param object $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if (ctype_digit($id)) {
            $attributes = Product::findOrFail($id)->attributes;
            if ($request->ajax()) {
                $values = Attribute::findOrFail($request->value)->attributeValues;
                $view = view('admin.attributes._data', compact('values'))->render();
                return response()->json(['html' => $view]);
            }
            $values = [];

            return view('admin.attributes.edit', compact('attributes', 'values', 'id'));
        }
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
        if (ctype_digit($id)) {
            $this->validate($request, [
                'attr_id' => 'required|numeric',
                'attr_name' => 'required',
                'value' => 'required',
            ]);
            $attribute = Attribute::findOrFail($request->input('attr_id'));
            $attribute->fill(['attr_name' => $request->input('attr_name')]);
            foreach ($request->input('value') as $value) {
                $attribute->attributeValues()->updateOrCreate([
                    'value' => $value
                ]);
            }
            $attribute->save();
            return redirect()->back()->with(['success' => 'attribute has updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (ctype_digit($id)) {
            $attr = Attribute::findOrFail($id);
            $attr->attributeValues()->delete();
            $attr->delete();
            return response()->json(['success' => $attr]);
        }
    }

    /**
     * Remove the attribute value.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteValue($id)
    {
        if (ctype_digit($id)) {
            $value = Attribute_Value::findOrFail($id)->delete();
            return response()->json(['success' => $value]);
        }
    }
}
