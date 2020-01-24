<?php

namespace App\Http\Controllers\Front;

use App\Exceptions\SessionExpiredException;
use App\Http\Controllers\Controller;
use App\Jobs\SendOrderEmailsJob;
use App\Mail\PaymentMail;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Filesystem\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Srmklive\PayPal\Services\ExpressCheckout;

class PayPalController extends Controller
{
    private $provider;

    public function __construct()
    {
        $this->provider = new ExpressCheckout();
    }

    /**
     * @return array
     * @throws SessionExpiredException
     */
    protected function getCart()
    {
        if (!session()->has('order_id')) {
            throw new SessionExpiredException();
        }

        $data = [];
        $cart_items = [];
        foreach (Cart::content() as $cart) {
            array_push($cart_items, [
                'name' => $cart->name,
                'price' => $cart->price,
                'desc' => $cart->options->attr . '.-Size:' . $cart->options->size . '.-Color:' . $cart->options->color,
                'qty' => $cart->qty,
            ]);
        }
        $subTotal = (substr(str_replace(',', '', Cart::subtotal()), 0, -3));
        $giftAmount = session('gift_price') ?? 0;
        $order_id = session()->get('order_id');
        $data['items'] = $cart_items;
        $data['invoice_id'] = $order_id;
        $data['invoice_description'] = "Your Order ID is {$data['invoice_id']} ";
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');
        $data['total'] = $subTotal;
        $data['shipping_discount'] = $giftAmount;
        return $data;

    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return  mixed
     * @throws SessionExpiredException
     */
    public function payment()
    {
        $data = $this->getCart();
        try {
            // send a request to paypal
            // paypal should respond with an array of data
            // the array should contain a link to paypal's payment system

            $response = $this->provider->setExpressCheckout($data);
            // This will redirect user to PayPal
            // after payment is done paypal
            // will redirect us back to $this->success
            return redirect($response['paypal_link']);
        } catch (\Exception $e) {
            $track_code = $this->savePayment($data, 'Invalid')['track_code'];
            return view('Front.check-out.error_payment', compact('track_code'));
        }

    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        $data['invoice_id'] = session('order_id');
        $track_code = $this->savePayment($data, 'canceled')['track_code'];
        return view('Front.check-out.cancel_payment', compact('track_code'));
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @param Request $request
     * @return void
     * @throws \Exception
     */
    public function success(Request $request)
    {

        $token = $request->get('token');
        $PayerID = $request->get('PayerID');

        $response = $this->provider->getExpressCheckoutDetails($request->token);

        $data = $this->getCart();
        if (!in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            $track_code = $this->savePayment($data, 'Invalid')['track_code'];
            return view('Front.check-out.error_payment', compact('track_code'));
        }

        $payment_status = $this->provider->doExpressCheckoutPayment($data, $token, $PayerID);
        $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
        //below test
        $payment = $this->savePayment($data, $status);
        $track_code = $payment['track_code'];
        if ($payment['status'] == 1) {
            return view('Front.check-out.success_payment', compact('track_code'));
        } else {
            return view('Front.check-out.error_payment', compact('track_code'));
        }


    }


    /**
     * @param Request $request
     */
    public function notify(Request $request)
    {

        // add _notify-validate cmd to request,
        // we need that to validate with PayPal that it was realy
        // PayPal who sent the request
        $request->merge(['cmd' => '_notify-validate']);
        $post = $request->all();
        // send the data to PayPal for validation
        $response = (string)$this->provider->verifyIPN($post);
        //if PayPal responds with VERIFIED we are good to go
        if ($response === 'VERIFIED') {
            if ($post['txn_type'] == 'recurring_payment' && $post['payment_status'] == 'Completed') {
//                $invoice = new Invoice();
//                $invoice->title = 'Recurring payment';
//                $invoice->price = $post['amount'];
//                $invoice->payment_status = 'Completed';
//                $invoice->recurring_id = $post['recurring_payment_id'];
//                $invoice->save();
            }

            $logFile = 'ipn_log_' . Carbon::now()->format('Ymd_His') . '.txt';
            Storage::disk('local')->put($logFile, print_r($post, true));


        }

    }

    /**
     * @param array $data
     * @param string $payment_status
     * @param int $status
     * @return array track_code
     */
    protected function savePayment(array $data, string $payment_status)
    {
        $order = Order::findOrFail(session()->pull('order_id'));
        //send email
        if (!strcasecmp($payment_status, 'Completed') || !strcasecmp($payment_status, 'Processed')) {
            $status = 1;
            if (session()->has('gift_id')) {
                DB::table('check_gift')->insert(['user_id' => auth()->id(), 'gift_id' => session('gift_id')]);
            }
        } else {
            $status = 0;
        }
        $payment = Payment::create([
            'order_id' => $data['invoice_id'],
            'user_id' => auth()->check() ? auth()->id() : null,
            'status' => $status,
            'payment_status' => $payment_status,
            'sub_total' => $order->totla_price
        ]);
        //change order status
        $order->update(['status' => 1]);
        $data = ['track' => $order->track_code, 'name' => $order->client_name, 'status' => $status];
        SendOrderEmailsJob::dispatch($order->client_email,$data);
//        $this->sendMail($data, $order);

        session()->forget('order_id');
        session()->forget('gift_id');
        session()->forget('gift_price');
        Cache::forget('menu_count');
        return ['track_code' => $order->track_code, 'status' => $status];
    }

    /**
     * send email
     * @param array $data
     * @param object $order
     */
    private function sendMail(array $data, $order)
    {
        Mail::to($order->client_email)->send(new PaymentMail($data));
    }


}
