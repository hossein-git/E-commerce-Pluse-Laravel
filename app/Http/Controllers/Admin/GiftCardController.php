<?php

namespace App\Http\Controllers\Admin;

use App\Models\GiftCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GiftCardController extends Controller
{

    private $gift;

    public function __construct()
    {
        $this->gift = new GiftCard();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gifts = $this->gift->paginate(15);
        return view('admin.giftCard.index', compact('gifts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.giftCard.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'gift_name' => 'required',
            'gift_code' => ['required','unique:gift_cards'],
            'gift_amount' => 'required',
        ]);
        $input = $request->except('token');
        if ( !$input['status'] == null ){
            $input['status'] = 1;
        }
        $input['gift_code'] = strtolower($input['gift_code']);
        $gift = $this->gift->create($input);
        if (env('APP_AJAX')){
            return response()->json(['success' => $gift]);
        }
        return view('admin.giftCard.create')->with(['success' => 'New Gift Card has created successfully']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (ctype_digit($id)){
            $gift = $this->gift->findOrFail($id);
            return view('admin.giftCard.edit',compact('gift'));
        }
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
        if (ctype_digit($id)){
            $this->validate($request,[
                'gift_name' => 'required',
//            'gift_code' => ['required','unique:gift_cards'],
                'gift_amount' => 'required',
            ]);
            $input = $request->except('token');
            if ( isset($input['status'])){
                $input['status'] = 1;
            }
            $input['gift_code'] = strtolower($input['gift_code']);
            $gift = $this->gift->findOrFail($id);
            $gift->fill($input);
            $gift->update();
            if (env('APP_AJAX')){
                return response()->json(['success' => $gift]);
            }
            return redirect()->route('giftCard.index')->with(['success' => ' Gift Card has updated successfully']);

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
        if (ctype_digit($id)){
            $gift = $this->gift->findOrFail($id)->delete();
            if ($gift){
                return response()->json(['success' => $gift]);
            }
            return response()->json(['error' => 'error']);
        }
    }
}
