@extends('layout.front.index' )
@section('title')
   test paypal
@stop
@section('extra_css')

@stop
@section('content')

   <!-- Profile Created -->

   <form target="_new" method="post" action="{{ url('/paypal/notify') }}">
@csrf
      <input type="hidden" name="verify_sign" value="ASsJ54wcfEJZVuwOMU8vBNHZb1TpAf7F4PMLvKL2uni1hb11jdOgdd2V" />
      <input type="hidden" name="period_type" value="Regular" />
      <input type="hidden" name="payer_status" value="verified" />
      <input type="hidden" name="test_ipn" value="1" />
      <input type="hidden" name="tax" value="0.00" />
      <input type="hidden" name="payer_email" value="sandbo_1204199080_biz@angelleye.com" />
      <input type="hidden" name="first_name" value="Drew" />
      <input type="hidden" name="receiver_email" value="sandbo_1215254764_biz@angelleye.com" />
      <input type="hidden" name="payer_id" value="E7BTGVXBFSUAU" />
      <input type="hidden" name="product_type" value="1" />
      <input type="hidden" name="payer_business_name" value="Drew Angell's Test Store" />
      <input type="hidden" name="shipping" value="0.00" />
      <input type="hidden" name="amount_per_cycle" value="30.00" />
      <input type="hidden" name="profile_status" value="Active" />
      <input type="hidden" name="charset" value="windows-1252" />
      <input type="hidden" name="notify_version" value="3.7" />
      <input type="hidden" name="amount" value="30.00" />
      <input type="hidden" name="outstanding_balance" value="0.00" />
      <input type="hidden" name="recurring_payment_id" value="I-VYR2VN3XPVW4" />
      <input type="hidden" name="product_name" value="The HALO Foundation Donation" />
      <input type="hidden" name="ipn_track_id" value="348867a2b7815" />
      <input type="submit" value="Send Profile Created"/> </form>

   <!-- Payment Made -->

   <form target="_new" method="post" action="{{ url('/paypal/notify') }}">
      @csrf
      <input type="hidden" name="mc_gross" value="10.00" />
      <input type="hidden" name="period_type" value=" Regular" />
      <input type="hidden" name="outstanding_balance" value="0.00" />
      <input type="hidden" name="next_payment_date" value="02:00:00 Dec 16, 2013 PST" />
      <input type="hidden" name="protection_eligibility" value="Ineligible" />
      <input type="hidden" name="payment_cycle" value="every 3 Months" />
      <input type="hidden" name="tax" value="0.00" />
      <input type="hidden" name="payer_id" value="3HMDJA96TEQN4" />
      <input type="hidden" name="payment_date" value="05:19:33 Sep 16, 2013 PDT" />
      <input type="hidden" name="payment_status" value="Completed" />
      <input type="hidden" name="product_name" value="platypu subscription" />
      <input type="hidden" name="charset" value="windows-1252" />
      <input type="hidden" name="recurring_payment_id" value="I-R52C41AGNEAP" />
      <input type="hidden" name="first_name" value="test" />
      <input type="hidden" name="mc_fee" value="0.64" />
      <input type="hidden" name="notify_version" value="3.7" />
      <input type="hidden" name="amount_per_cycle" value="10.00" />
      <input type="hidden" name="payer_status" value="unverified" />
      <input type="hidden" name="currency_code" value="USD" />
      <input type="hidden" name="business" value="sandbo_1215254764_biz@angelleye.com" />
      <input type="hidden" name="verify_sign" value="A4QWarlQUU0cupDGeAi-McuvfslGA7lrbrWV735PGPsr3OKdTRFyJtOq" />
      <input type="hidden" name="payer_email" value="test@domain.com" />
      <input type="hidden" name="initial_payment_amount" value="0.00" />
      <input type="hidden" name="profile_status" value="Active" />
      <input type="hidden" name="amount" value="10.00" />
      <input type="hidden" name="txn_id" value="34Y69196BK064583G" />
      <input type="hidden" name="payment_type" value="instant" />
      <input type="hidden" name="last_name" value="test" />
      <input type="hidden" name="receiver_email" value="sandbo_1215254764_biz@angelleye.com" />
      <input type="hidden" name="payment_fee" value="0.64" />
      <input type="hidden" name="receiver_id" value="ATSCG2QMC9KAU" />
      <input type="hidden" name="txn_type" value="recurring_payment" />
      <input type="hidden" name="mc_currency" value="USD" />
      <input type="hidden" name="residence_country" value="US" />
      <input type="hidden" name="test_ipn" value="1" />
      <input type="hidden" name="receipt_id" value="1660-1430-7506-9911" />
      <input type="hidden" name="transaction_subject" value="" />
      <input type="hidden" name="payment_gross" value="10.00" />
      <input type="hidden" name="shipping" value="0.00" />
      <input type="hidden" name="product_type" value="1" />
      <input type="hidden" name="time_created" value="07:54:24 Sep 05, 2013 PDT" />
      <input type="hidden" name="ipn_track_id" value="efd4ee6ea4474" />
      <input type="submit" value="Send Payment Made"/> </form>

   <!-- Payment Skipped -->

   <form target="_new" method="post" action="{{ url('/paypal/notify') }}">
      @csrf
      <input type="hidden" name="payment_cycle" value="Monthly" />
      <input type="hidden" name="txn_type" value="recurring_payment_skipped" />
      <input type="hidden" name="last_name" value="bitch" />
      <input type="hidden" name="next_payment_date" value="03:00:00 Sep 21, 2013 PDT" />
      <input type="hidden" name="residence_country" value="US" />
      <input type="hidden" name="initial_payment_amount" value="0.00" />
      <input type="hidden" name="currency_code" value="USD" />
      <input type="hidden" name="time_created" value="19:42:33 Jan 11, 2013 PST" />
      <input type="hidden" name="verify_sign" value="AcyQRlWufyrh0B6-n5swEgNB9oNJAkMm65cAu2bQLTevdnT2JnuIyDQO" />
      <input type="hidden" name="period_type" value=" Regular" />
      <input type="hidden" name="payer_status" value="unverified" />
      <input type="hidden" name="test_ipn" value="1" />
      <input type="hidden" name="tax" value="0.00" />
      <input type="hidden" name="payer_email" value="tester@hey.com" />
      <input type="hidden" name="first_name" value="working" />
      <input type="hidden" name="receiver_email" value="sandbo_1215254764_biz@angelleye.com" />
      <input type="hidden" name="payer_id" value="4ATNY663RDKJA" />
      <input type="hidden" name="product_type" value="1" />
      <input type="hidden" name="shipping" value="0.00" />
      <input type="hidden" name="amount_per_cycle" value="10.00" />
      <input type="hidden" name="profile_status" value="Active" />
      <input type="hidden" name="charset" value="windows-1252" />
      <input type="hidden" name="notify_version" value="3.7" />
      <input type="hidden" name="amount" value="10.00" />
      <input type="hidden" name="outstanding_balance" value="60.00" />
      <input type="hidden" name="recurring_payment_id" value="I-LH2MJXG27TR6" />
      <input type="hidden" name="product_name" value="Angell EYE Web Hosting" />
      <input type="hidden" name="ipn_track_id" value="e3a52d6772d28" />
      <input type="submit" value="Send Payment Skipped"/> </form>

   <!-- Payment Failed -->

   <form target="_new" method="post" action="{{ url('/paypal/notify') }}">
      @csrf
      <input type="hidden" name="payment_cycle" value="every 4 Weeks" />
      <input type="hidden" name="txn_type" value="recurring_payment_failed" />
      <input type="hidden" name="last_name" value="Tester" />
      <input type="hidden" name="next_payment_date" value="03:00:00 Oct 03, 2013 PDT" />
      <input type="hidden" name="residence_country" value="US" />
      <input type="hidden" name="initial_payment_amount" value="0" />
      <input type="hidden" name="currency_code" value="JPY" />
      <input type="hidden" name="time_created" value="05:14:37 Aug 01, 2012 PDT" />
      <input type="hidden" name="verify_sign" value="AOTn5qT2D05NGLBeQowuGwhI5kTFAIPV01VWay1FayueRmXhAYd2KLZp" />
      <input type="hidden" name="period_type" value=" Regular" />
      <input type="hidden" name="payer_status" value="unverified" />
      <input type="hidden" name="test_ipn" value="1" />
      <input type="hidden" name="tax" value="0" />
      <input type="hidden" name="payer_email" value="prachi@signyit.com" />
      <input type="hidden" name="first_name" value="Ecaf" />
      <input type="hidden" name="receiver_email" value="sandbo_1215254764_biz@angelleye.com" />
      <input type="hidden" name="payer_id" value="VCLJR9E79V4KJ" />
      <input type="hidden" name="product_type" value="1" />
      <input type="hidden" name="shipping" value="0" />
      <input type="hidden" name="amount_per_cycle" value="1" />
      <input type="hidden" name="profile_status" value="Active" />
      <input type="hidden" name="charset" value="windows-1252" />
      <input type="hidden" name="notify_version" value="3.7" />
      <input type="hidden" name="amount" value="1" />
      <input type="hidden" name="outstanding_balance" value="1" />
      <input type="hidden" name="recurring_payment_id" value="I-P90BX92X15DR" />
      <input type="hidden" name="product_name" value="Welcome to the world of shopping where you get everything" />
      <input type="hidden" name="ipn_track_id" value="ab99ea6823e24" />
      <input type="submit" value="Send Payment Failed"/> </form>

   <!-- Profile Suspended -->

   <form target="_new" method="post" action="{{ url('/paypal/notify') }}">
      @csrf
      <input type="hidden" name="payment_cycle" value="Monthly" />
      <input type="hidden" name="txn_type" value="recurring_payment_suspended_due_to_max_failed_payment" />
      <input type="hidden" name="last_name" value="Lang" />
      <input type="hidden" name="next_payment_date" value="N/A" />
      <input type="hidden" name="residence_country" value="US" />
      <input type="hidden" name="initial_payment_amount" value="4.90" />
      <input type="hidden" name="currency_code" value="USD" />
      <input type="hidden" name="time_created" value="13:45:44 Nov 04, 2010 PDT" />
      <input type="hidden" name="verify_sign" value="A65EYvoNuupMDbNU-2RPi609XJ7LAQ8CzxOV03bR4.O-nKSYG9LjBf10" />
      <input type="hidden" name="period_type" value=" Regular" />
      <input type="hidden" name="payer_status" value="unverified" />
      <input type="hidden" name="test_ipn" value="1" />
      <input type="hidden" name="tax" value="0.00" />
      <input type="hidden" name="payer_email" value="corey@angelleye.com" />
      <input type="hidden" name="first_name" value="Corey" />
      <input type="hidden" name="receiver_email" value="sandbo_1215254764_biz@angelleye.com" />
      <input type="hidden" name="payer_id" value="HKHX3D32P9DXG" />
      <input type="hidden" name="product_type" value="1" />
      <input type="hidden" name="shipping" value="0.00" />
      <input type="hidden" name="amount_per_cycle" value="29.95" />
      <input type="hidden" name="profile_status" value="Suspended" />
      <input type="hidden" name="charset" value="windows-1252" />
      <input type="hidden" name="notify_version" value="3.7" />
      <input type="hidden" name="amount" value="29.95" />
      <input type="hidden" name="outstanding_balance" value="149.75" />
      <input type="hidden" name="recurring_payment_id" value="I-Y0E6UC684RS4" />
      <input type="hidden" name="product_name" value="Achieve Formulas 30 day supply, monthly." />
      <input type="hidden" name="ipn_track_id" value="95c39c8a4b39d" />
      <input type="submit" value="Send Profile Suspended"/> </form>

   <!-- Profile Canceled -->

   <form target="_new" method="post" action="{{ url('/paypal/notify') }}">
      @csrf
      <input type="hidden" name="payment_cycle" value="Monthly" />
      <input type="hidden" name="txn_type" value="recurring_payment_profile_cancel" />
      <input type="hidden" name="last_name" value="Testerson" />
      <input type="hidden" name="next_payment_date" value="N/A" />
      <input type="hidden" name="residence_country" value="US" />
      <input type="hidden" name="initial_payment_amount" value="69.90" />
      <input type="hidden" name="rp_invoice_id" value="4603" />
      <input type="hidden" name="currency_code" value="USD" />
      <input type="hidden" name="time_created" value="09:40:52 Feb 11, 2013 PST" />
      <input type="hidden" name="verify_sign" value="AGiC06LknLf7LnPNSt03A0q0ajKiAZt35jsIvkcPn5dU7GtRl-ITAf5Q" />
      <input type="hidden" name="period_type" value=" Regular" />
      <input type="hidden" name="payer_status" value="verified" />
      <input type="hidden" name="tax" value="0.00" />
      <input type="hidden" name="payer_email" value="payer@email.com" />
      <input type="hidden" name="first_name" value="Tester" />
      <input type="hidden" name="receiver_email" value="sandbox@domain.com" />
      <input type="hidden" name="payer_id" value="Q28888N" />
      <input type="hidden" name="product_type" value="1" />
      <input type="hidden" name="shipping" value="0.00" />
      <input type="hidden" name="amount_per_cycle" value="1.95" />
      <input type="hidden" name="profile_status" value="Cancelled" />
      <input type="hidden" name="charset" value="windows-1252" />
      <input type="hidden" name="notify_version" value="3.7" />

      <input type="hidden" name="outstanding_balance" value="0.00" />
      <input type="hidden" name="recurring_payment_id" value="I-553Y5PRWJ29F" />
      <input type="hidden" name="product_name" value="USBSwiper Monthly Subscription" />
      <input type="hidden" name="ipn_track_id" value="5ecdc90112398" />
      <input type="submit" value="Send Profile Canceled"/> </form>

   <!-- Recurring Payment Expired -->

   <form target="_new" method="post" action="{{ url('/paypal/notify') }}">
      @csrf
      <input type="hidden" name="payment_cycle" value="Monthly" />
      <input type="hidden" name="txn_type" value="recurring_payment_expired" />
      <input type="hidden" name="last_name" value="Testerson" />
      <input type="hidden" name="next_payment_date" value="N/A" />
      <input type="hidden" name="residence_country" value="US" />
      <input type="hidden" name="initial_payment_amount" value="0.00"/>
      <input type="hidden" name="rp_invoice_id" value="1580"/>
      <input type="hidden" name="currency_code" value="USD"/>
      <input type="hidden" name="time_created" value="09:42:46 Jan 12, 2011 PST"/>
      <input type="hidden" name="verify_sign" value="AbBIww12EQnvrHwYmd1wb98zYz53APIJHOa.GTV4C9Ef0HVE1FWBtxMP"/>
      <input type="hidden" name="period_type" value=" Regular"/>
      <input type="hidden" name="payer_status" value="unverified"/>
      <input type="hidden" name="tax" value="0.00"/>
      <input type="hidden" name="first_name" value="Tester" />
      <input type="hidden" name="receiver_email" value="payments@domain.com" />
      <input type="hidden" name="payer_id" value="R7J55555MN" />
      <input type="hidden" name="product_type" value="1" />
      <input type="hidden" name="shipping" value="0.00" />
      <input type="hidden" name="amount_per_cycle" value="1.00" />
      <input type="hidden" name="profile_status" value="Cancelled" />
      <input type="hidden" name="charset" value="windows-1252" />
      <input type="hidden" name="notify_version" value="3.0" />
      <input type="hidden" name="amount" value="1.00" />
      <input type="hidden" name="outstanding_balance" value="0.00" />
      <input type="hidden" name="recurring_payment_id" value="I-M0555555RY" />
      <input type="hidden" name="product_name" value="USBSwiper Rental Program" />
      <input type="submit" value="Send Recurring Payment Expired"/> </form>
@endsection
@section('extra_js')


@stop