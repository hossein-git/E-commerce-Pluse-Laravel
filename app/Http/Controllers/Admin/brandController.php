<?php

namespace App\Http\Controllers\Admin;

use App\Models\brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class brandController extends Controller
{
    private $brand;

    public function __construct()
    {
        $this->brand = new brand();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = $this->brand->paginate(15);
        return view('admin.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create');
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
            'brand_name' => 'required',
            'brand_slug' => 'required',
            'brand_image' => 'required',
            'brand_description' => 'required',
        ]);
        $input = $request->except('_token');
        if ($image = $request->file('brand_image')) {
            $image_type = $image->getClientOriginalExtension();
            $image_name = $input['brand_name'] . ',' . date('Y_m_d_H,i,s') . '.' . $image_type;
            $image->move(env('IMAGE_PATH'), $image_name);
            $input['brand_image'] = $image_name;
        }
        $brand = $this->brand->create($input);
        if (env('APP_AJAX') == true) {
            return response()->json(['success' => $brand]);
        }
        return redirect()->route('brand.create')->with(['success' => 'new brand has been created successfully']);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = $this->brand->findOrFail($id);
        return view('admin.brand.create', compact('brand'));
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
        if (!ctype_digit($id)){
            return response()->json(['error' => 'id is not valid']);
        }
        $this->validate($request, [
            'brand_name' => 'required',
            'brand_slug' => 'required'
        ]);
        $brand = $this->brand->findOrFail($id);
        $brand->fill($request->except('_token'));
        $brand->update();
        if (env('APP_AJAX') == true) {
            return response()->json(['success' => $brand]);
        }
        return redirect()->route('brand.create')->with(['success' => 'brand has updated successfully']);

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
            $brand = $this->brand->findOrFail($id);
            $brand->delete();
            return response()->json(['success' => $brand]);
        }
    }
}
