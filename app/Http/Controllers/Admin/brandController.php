<?php

namespace App\Http\Controllers\Admin;

use App\Models\brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class brandController extends Controller
{
    private $brand;
    private $cachKey;

    public function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);

        $this->brand = new brand();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_brands = $this->brand->paginate(15);

        return view('admin.brand.index', compact('admin_brands'));
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
            'brand_name' => 'required|string',
            'brand_slug' => 'required|string|unique:brands',
            'brand_image' => 'required',
            'brand_description' => 'required|string',
        ]);
        $input = $this->savePhoto($request);
        $brand = $this->brand->create($input);
        Cache::forget($this->cachKey);
        return env('APP_AJAX')
            ? response()->json(['success' => $brand])
            : redirect()->route('brand.create')->with(['success' => 'new brand has been created successfully']);

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
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!ctype_digit($id)) {
            return response()->json(['error' => 'id is not valid']);
        }
        $this->validate($request, [
            'brand_name' => 'required|string',
            'brand_slug' => 'required|string',
            'brand_description' => 'required|string',
            'brand_image' => 'required'
        ]);
        $input = $this->savePhoto($request);

        $brand = $this->brand->findOrFail($id);
        $brand->fill($input)->update();
        $result = $brand->save();
        Cache::forget($this->cachKey);
        if (env('APP_AJAX') and $result) {
            return response()->json(['success' => $brand]);
        }
        if ($result) {
            return redirect()->route('brand.create')->with(['success' => 'brand has updated successfully']);
        } else {
            return redirect()->route('brand.create')->with(['error' => 'brand update error']);
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
            $brand = $this->brand->findOrFail($id);
            $brand->delete();
            Cache::forget($this->cachKey);
            return response()->json(['success' => $brand]);
        }
    }

    /**
     * TO SAVE PHOTO IN UPDATE AND CREATE METHOD
     *
     * @param Request $request
     * @return array $input
     */
    private function savePhoto($request)
    {
        $input = $request->except('_token');
        if ($image = $request->file('brand_image')) {
            $image_type = $image->getClientOriginalExtension();
            $image_name = $input['brand_name'] . ',' . date('Y_m_d_H,i,s') . '.' . $image_type;
            $image->move(env('IMAGE_PATH'), $image_name);
            $input['brand_image'] = $image_name;
        }
        return $input;
    }
}
