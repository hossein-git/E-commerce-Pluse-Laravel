<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\Attribute;
use App\Models\Attribute_Value;
use App\Models\Product;
use App\Repositories\AttributeRepository;
use Facade\FlareClient\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laracasts\Flash\Flash;

class attributeController extends AppBaseController
{

    /**
     * @var AttributeRepository
     */
    private $attributeRepo;

    /**
     * @var product
     */
    private $product;


    public function __construct(AttributeRepository $repository)
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);

        $this->attributeRepo = $repository;
        $this->product = new Product();
    }


    /**
     * Show the form for creating a new attr.
     *
     * @return view
     */
    public function create()
    {
        $products = $this->product->all(['product_id', 'product_name']);
        return view($this->attributeRepo->viewPrefix . 'create', compact('products'));
    }

    /**
     * Show the form for creating a new attr from product show.
     * @param int $id
     * @return view
     */
    public function createNew($id)
    {

        $this->attributeRepo->checkId($id);
        $product = $this->product->findOrFail($id, ['product_id', 'product_name']);
        return view($this->attributeRepo->viewPrefix . 'create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|numeric',
            'attr_name' => 'required',
            'value' => 'required'
        ]);
        $attr = $this->attributeRepo->saveAttribute($request);
        return $this->attributeRepo->passViewAfterCreated($attr, 'attributes', 'product.index');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws \Throwable
     */
    public function edit(Request $request, $id)
    {
        $this->attributeRepo->checkId($id);
        $attributes = $this->product->findOrFail($id)->attributes;
        if ($request->ajax()) {
            $values = Attribute::findOrFail($request->value)->attributeValues;
            $view = view($this->attributeRepo->viewPrefix . '_data', compact('values'))->render();
            return response()->json(['html' => $view]);
        }
        $values = [];

        return view($this->attributeRepo->viewPrefix . 'edit', compact('attributes', 'values', 'id'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {

        $this->attributeRepo->checkId($id);
        $this->validate($request, [
            'attr_id' => 'required|numeric',
            'attr_name' => 'required',
            'value' => 'required',
        ]);

        $attr = $this->attributeRepo->updateAttribute($request);

        return $this->attributeRepo->passViewAfterUpdated($attr, 'attributes', 'product.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Facade\FlareClient\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $attr = $this->attributeRepo->find($id);
        $attr->attributeValues()->delete();
        $attr = $attr->delete();
        return $this->attributeRepo->passViewAfterDeleted($attr, 'attributes');

    }

    /**
     * Remove the attribute value.
     *
     * @param int $id
     * @return \Facade\FlareClient\Http\Response
     */
    public function deleteValue($id)
    {
        $this->attributeRepo->checkId($id);
        $value = Attribute_Value::findOrFail($id)->delete();
        return $this->attributeRepo->passViewAfterDeleted($value, 'attributeValues');
    }
}
