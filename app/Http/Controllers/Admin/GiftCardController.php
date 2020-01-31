<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Brands\GiftCardUpdateRequest;
use App\Models\GiftCard;
use App\Repositories\GiftCardRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class GiftCardController extends AppBaseController
{

    private $gift;
    /**
     * @var GiftCardRepository
     */
    private $giftCardRepo;

    public function __construct(GiftCardRepository $repository)
    {
        $this->middleware('permission:gift-list|gift-create|gift-edit|gift-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:gift-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:gift-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:gift-delete', ['only' => ['destroy']]);

        $this->gift = new GiftCard();
        $this->giftCardRepo = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $gifts = $this->gift->paginate(15);
        return view('admin.giftCard.index', compact('gifts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.giftCard.create');
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
        $this->validate($request, GiftCard::$rules);
        $gift = $this->giftCardRepo->createGiftCard($request);
        return $this->giftCardRepo->passViewAfterCreated($gift, 'giftCards', 'giftCard.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $gift = $this->giftCardRepo->find($id);
        return view('admin.giftCard.edit', compact('gift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GiftCardUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(GiftCardUpdateRequest $request, $id)
    {
        $gift = $this->giftCardRepo->updateGiftCard($request, $id);

        return $this->giftCardRepo->passViewAfterUpdated($gift, 'giftCards', 'giftCard.index');

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
        $gift = $this->giftCardRepo->delete($id);
        return $this->giftCardRepo->passViewAfterDeleted($gift, 'giftCards');
    }
}
