<?php

namespace App\Http\Controllers\Admin;

use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class PhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:product-delete', ['only' => 'destroy' ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
        $photo_path = public_path(env("IMAGE_PATH") . $photo->addr);
        //THUMBNAIL PATH of photo
        $T_path = public_path(env("THUMBNAIL_PATH") . "T" . $photo->addr);
        if (File::exists($T_path)) {
            unlink($T_path);
        }
        if (File::exists($photo_path)) {
            unlink($photo_path);
        }
        $photo->delete();
        if ($photo){
            return response()->json(1);
        }
    }
}
