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
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'site_title' => 'required|string',
            'site_description' => 'required|string',
            'site_logo' => 'image|mimes:jpeg,png,jpg',
            'site_icon' => 'image|mimes:jpeg,png,jpg',
            'site_address' => 'required|string'
            , 'site_phone' => 'required|string',
            'site_email' => 'required|string',
            'site_fax' => 'required|string'
        ]);
        $input = $request->except('_token');
        $setting = $this->setting->findOrFail($id);
        if ($img = $request->file('site_logo')) {
            $input['site_logo'] = $this->saveImage($setting->site_image, $img);
        }
        if ($img = $request->file('site_icon')) {
            $input['site_icon'] = $this->saveImage($setting->site_image, $img);
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


    /**
     * save images
     * @param null $img_name
     * @param $img
     * @return string
     */
    private function saveImage($img_name = null, $img)
    {
        if ($img_name) {
            $photo_path = public_path(env("IMAGE_PATH") . $img_name);
            if (File::exists($photo_path)) {
                unlink($photo_path);
            }
        }
        $name = $img->getClientOriginalName();
        $image_name = 'setting_' . "$name";
        $img->move(env('IMAGE_PATH'), $image_name);
        return $image_name;

    }


}
