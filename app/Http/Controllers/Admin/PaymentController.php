<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\Payment;
use App\Repositories\PaymentRepository;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PaymentController extends AppBaseController
{
    private $payment;
    /**
     * @var PaymentRepository
     */
    private $paymentRepo;


    public function __construct(PaymentRepository $repository)
    {
        $this->middleware('permission:order-edit');

        $this->payment = new Payment();
        $this->paymentRepo = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $payments = $this->payment->paginate(10)->load('users','order');
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * take failed payments
     * @return View
     */
    public function failed()
    {
        $payments = $this->payment->with('users','order')->where('status', 0)->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Payment $payment
     * @return Response
     */
    public function show(Payment $payment)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Payment $payment
     * @return Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
