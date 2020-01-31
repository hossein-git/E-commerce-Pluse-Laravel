<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;

class categoryController extends Controller
{
    private $category;
    /**
     * @var CategoryRepository
     */
    private $categoryRepo;

    public function __construct(CategoryRepository $repository)
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);

        $this->category = new Category();
        $this->categoryRepo = $repository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $main_categories = $this->category->with('children')->whereIsRoot()->paginate(10);
        return view('admin.category.index', compact('main_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return view
     */
    public function create()
    {
        $allCategories = $this->category->all(['category_id', 'category_name', 'parent_id']);
        return view('admin.category.create', compact('allCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, Category::$rules);
        $category = $this->categoryRepo->saveCategory($request);

        return $this->categoryRepo->passViewAfterCreated( $category, 'categories', 'category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Facade\FlareClient\Http\Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $category = $this->categoryRepo->destroy($id);
        return $this->categoryRepo->passViewAfterDeleted($category,'categories');
    }
}
