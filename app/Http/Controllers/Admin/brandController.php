<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Brands\BrandUpdateRequest;
use App\Models\brand;
use App\Repositories\BrandRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laracasts\Flash\Flash;

class brandController extends AppBaseController
{
    private $brand;

    /**
     * @var BrandRepository
     */
    private $brandRepo;

    public function __construct(BrandRepository $repository)
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);

        $this->brand = new brand();
        $this->brandRepo = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $admin_brands = $this->brandRepo->paginate(15);

        return view('admin.brand.index', compact('admin_brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.brand.create');
    }


    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, brand::$rules);
        $brand = $this->brandRepo->saveBrand($request);
        return $this->brandRepo->passViewAfterCreated($brand,'brands','brand.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $brand = $this->brandRepo->find($id);
        return view('admin.brand.create', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BrandUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(BrandUpdateRequest $request, $id)
    {
        $result = $this->brandRepo->updateBrand($request, $id);

        return $this->brandRepo->passViewAfterUpdated($result,'brands','brand.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Facade\FlareClient\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $result = $this->brandRepo->delete($id);
        Cache::forget($this->brandRepo->cacheKey);
        return $this->brandRepo->passViewAfterDeleted($result,'brands');
    }


}
