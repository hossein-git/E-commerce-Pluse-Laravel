<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $payment;

    public function __construct()
    {
        $this->middleware('permission:order-edit');

        $this->payment = new Payment();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * take failed payments
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function failed()
    {
        $payments = Payment::where('status', 0)->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
