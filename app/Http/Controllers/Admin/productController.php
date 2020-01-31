<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\SessionExpiredException;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Products\productRequest;
use App\Http\Requests\Products\SecondStepProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Tag;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class productController extends AppBaseController
{
    private $productRepo;
    private $product;
    private $category;
    private $paginate;


    public function __construct(ProductRepository $repository)
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);

        $this->productRepo = $repository;
        $this->product = new Product();
        $this->category = new Category();
        $this->paginate = $repository->paginateNum;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = $this->product->with(['categories', 'colors'])->paginate($this->paginate);
        $index_categories = $this->category->all(['category_slug', 'category_name']);
        return view($this->productRepo->viewPrefix . 'index', compact('products', 'index_categories'));
    }

    /**
     * take trash products
     * @return Factory|View
     */
    public function withTrash()
    {
        $products = $this->product->onlyTrashed()->with(['categories', 'colors'])->paginate($this->paginate);
        return view($this->productRepo->viewPrefix . 'index', compact('products'));
    }

    /**
     * sort and listing products
     * @param Request $request
     * @return Factory|JsonResponse|View
     * @throws ValidationException
     * @throws Throwable
     */
    public function sort(Request $request)
    {
        $this->validate($request, [
            'sort' => 'string|required',
            'sort_category' => 'string|nullable',
            'dcs' => 'string|required',
        ]);
        $index_categories = true;
        $query = $this->product;
        if ($request->status) {
            $query = $this->product->where('status', 1);
        }
        if ($cat_slug = $request->sort_category) {
            $products = $query->whereHas("categories", function ($query) use ($cat_slug) {
                return $query->where('category_slug', $cat_slug);
            })->orderBy("$request->sort", "$request->dcs")->paginate($this->paginate);

        } else {
            $products = $query->orderBy("$request->sort", "$request->dcs")->paginate($this->paginate);
        }
        if ($request->ajax()) {
            $view = view('admin.products._data', compact('products', 'index_categories'))->render();
            return response()->json(['html' => $view]);
        }
        // this var provide to display 'restore' icon
        return view($this->productRepo->viewPrefix . 'index', compact('products', 'index_categories'));
    }

    /**
     * Route : product/index/restore name:product.restore
     * @param $id
     * @return \Facade\FlareClient\Http\Response
     */
    public function restore(int $id)
    {
        $product = $this->productRepo->findWithTrash($id)->restore();
        return $this->productRepo->passResponse($product, 'products', 'restored');
    }

    /* Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $brands = brand::all(['brand_id', 'brand_name']);
        return view($this->productRepo->viewPrefix . 'create', compact('brands'));
    }


    /* Show the second step for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function createSecondStep()
    {
        $colors = Color::all(['color_id', 'color_name']);
        $categories = $this->category->all(['category_id', 'category_name']);
        return view($this->productRepo->viewPrefix . 'create2', compact('colors', 'categories'));
    }

    /**
     * Show tags in tag input- create product page .
     *
     * @param $tag string
     * @return Response
     */
    public function productTags(string $tag)
    {
        $tags = Tag::where('tag_slug', 'like', '%' . $tag . '%')->pluck('tag_name')->toArray();
        return response()->json($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\productRequest $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function store(productRequest $request)
    {

        $product = $this->productRepo->createProduct($request);
        if ($product) {
            session()->put('create-product', $product);
        }

        return $this->productRepo->passViewAfterCreated($product, 'products', 'product.create2');
    }

    /**
     * @param SecondStepProductRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws SessionExpiredException
     */
    public function storeSecondStep(SecondStepProductRequest $request)
    {
        if (!session()->has('create-product')) {
            if ($request->ajax()){
                return $this->sendError('your session expired',440);
            }
            throw new SessionExpiredException();
        }
        $product = $this->productRepo->createProductSecondStep($request);
        if ($product) {
            session()->forget('create-product');
        }
        return $this->productRepo->passViewAfterCreated($product, 'products', 'product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $product = $this->productRepo->find($id)->load('comments');
        $comments = $product->comments()->paginate(4);
        $colors = $product->colors(['color_name', 'color_code'])->get();
        $averageRating = $product->averageRating;
        $categories = $product->categories(['category_name'])->get();
        return view($this->productRepo->viewPrefix . 'show', compact(
            'product', 'comments', 'colors', 'averageRating', 'categories'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $product = $this->productRepo->find($id);
        $colors = Color::all(['color_id', 'color_name']);
        $p_colors = $product->colors->pluck('color_id')->toArray();
        $categories = $this->category->all(['category_id', 'category_name']);
        $p_categories = $product->categories->pluck('category_id')->toArray();
        $brands = brand::all(['brand_id', 'brand_name']);
        return view($this->productRepo->viewPrefix . 'edit',
            compact('product', 'colors', 'categories', 'brands', 'p_categories', 'p_colors'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param int $id
     * @return JsonResponse|RedirectResponse
     */
    public function update(UpdateProductRequest $request, $id)
    {

        $product = $this->productRepo->updateProduct($request, $id);
        return $this->productRepo->passViewAfterUpdated($product, 'products', 'product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Facade\FlareClient\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->productRepo->destroy($id);
        return $this->productRepo->passViewAfterDeleted($product, 'products');
    }


}
