<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class settingController extends Controller
{
    private $setting;

    public function __construct()
    {
        $this->middleware('permission:role-edit');
        $this->setting = new Setting();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = $this->setting->first();
        return view('admin.setting.index', compact('setting'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        $this->validate($request,[
            'site_title' => 'required|string',
            'site_description' => 'required|string',
            'site_logo' => 'image|mimes:jpeg,png,jpg',
            'site_address' => 'required|string'
            , 'site_phone' => 'required|string',
            'site_email' => 'required|string',
            'site_fax' => 'required|string'
        ]);
        $input = $request->except('_token');
        $setting = $this->setting->findOrFail($id);
        if ($logo = $request->file('site_logo')) {
            $photo_path = public_path(env("IMAGE_PATH") . $setting->site_logo);
            if (File::exists($photo_path)) {
                unlink($photo_path);
            }
            $image_type = $logo->getClientOriginalExtension();
            $image_name = 'site_logo' . '.' . $image_type;
            $logo->move(env('IMAGE_PATH'), $image_name);
            $input['site_logo'] = $image_name;
        }
        $setting->fill($input);

        Cache::forget('setting');
        $setting->save();

        if ($setting) {
            return env('APP_AJAX')
                ? response()->json(['success' => 'settings updated successfully '])
                : redirect()->route('settings.index')->with(['success' => 'settings updated successfully ']);
        }

    }

}
