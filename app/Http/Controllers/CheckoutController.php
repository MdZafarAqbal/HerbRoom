<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmed;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shipping;
use Auth;
use Carbon\Carbon;
use Helper;
use Illuminate\Http\Request;
use Mail;
use Session;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
      $current_month = Carbon::now()->month;
      $current_year = Carbon::now()->year;
      $current_date = Carbon::now()->toDateString();

      if (Auth::check()) {
        $user_id = Auth()->user()->id;
        if (empty(CartItem::where('user_id', $user_id)->get()))
          return back()->with('error', 'Your cart is empty. Add items to cart for checkout.');
      } else { 
        $user_id = null;
        if (empty(session('cart')))
          return back()->with('error', 'Your cart is empty. Add items to cart for checkout.');
      }

      $validated = $request->validate([
        'cust_type' => ['required', 'string'],
        'fname' => ['nullable', 'required_if:cust_type,individual', 'regex:/^[\p{L}\p{M} ]*[\p{L}\p{M}]{1,}[\p{L}\p{M} ]*[\p{L}\p{M}]{1,}$/u'],
        'lname' => ['nullable', 'required_if:cust_type,individual', 'regex:/^[\p{L}\p{M} ]*[\p{L}\p{M}]{1,}[\p{L}\p{M} ]*[\p{L}\p{M}]{1,}$/u'],
        'cname' => ['nullable', 'required_if:cust_type,company', 'string', 'min:3'],
        'trn_no' => ['nullable', 'required_if:cust_type,company', 'min_digits:15'],
        'email' => ['required', 'email:strict,dns'],
        'address' => ['required', 'string', 'regex: /\w+(\s\w+){2,}/'],
        'landmark' => ['nullable', 'string'],
        'country' => ['required', 'numeric'],
        'state' => ['required', 'numeric'],
        'city' => ['required', 'numeric'],
        'phone' => ['required', 'regex: /^(?:50|52|54|55|56|58|1|2|3|4|6|7|8|9)( *\d *){7}$/'],
        'altphone' => ['nullable', 'regex: /^(?:50|52|54|55|56|58|1|2|3|4|6|7|8|9)( *\d *){7}$/'],
        'shipping_fname' => ['nullable', 'required_if:shipping_option,different', 'regex:/^[\p{L}\p{M} ]*[\p{L}\p{M}]{1,}[\p{L}\p{M} ]*[\p{L}\p{M}]{1,}$/u'],
        'shipping_lname' => ['nullable', 'required_if:shipping_option,different', 'regex:/^[\p{L}\p{M} ]*[\p{L}\p{M}]{1,}[\p{L}\p{M} ]*[\p{L}\p{M}]{1,}$/u'],
        'shipping_address' => ['nullable', 'required_if:shipping_option,different', 'string', 'regex: /\w+(\s\w+){2,}/'],
        'shipping_landmark' => ['nullable', 'string'],
        'shipping_country' => ['nullable', 'required_if:shipping_option,different', 'numeric'],
        'shipping_state' => ['nullable', 'required_if:shipping_option,different', 'numeric'],
        'shipping_city' => ['nullable', 'required_if:shipping_option,different', 'numeric'],
        'shipping_phone' => ['nullable', 'required_if:shipping_option,different', 'regex: /^(?:50|52|54|55|56|58|1|2|3|4|6|7|8|9)( *\d *){7}$/'],
        'shipping_altphone' => ['nullable', 'regex: /^(?:50|52|54|55|56|58|1|2|3|4|6|7|8|9)( *\d *){7}$/'],
        'account_no' => ['nullable', 'required_if:pay_mthd,op', 'regex: /^(?:4(\d *){12}(?:(\d *){3})?|(?:5[1-5](\d *){2}|222[1-9]|22[3-9](\d *)|2[3-6](\d *){2}|27[01](\d *)|2720)(\d *){12})$/'],
        'account_name' => ['nullable', 'required_if:pay_mthd,op', 'regex: /^ ?[A-Za-z]\D{2,} ?$/'],
        'cvv_cvc' => ['nullable', 'required_if:pay_mthd,op', 'regex: /(?!000)\d{3}/'],
        'expiry_month' => ['nullable', 'required_if:pay_mthd,op', 'regex: /(?!00)\d{2}/'],
        'expiry_year' => ['nullable', 'required_if:pay_mthd,op', 'gte:' . $current_year, 'lte:' . ($current_year+5)]
      ]);

      if ($request->expiry_year == $current_year) {
        $request->validate([
          'expiry_month' => 'gte:' . $current_month
        ]);
      }

      $name = ($request->cust_type == 'individual') ? ($request->fname . $request->lname) : ($request->cname);

      if ($request->shipping_option == 'different') {
        $address = $request->shipping_address;
        $phone = $request->shipping_phone;
      } else {
        $address = $request->address;
        $phone = $request->phone;
      }
      
      $order_no = 'HC-' . (new OrderController)->generateUniqueCode();

      $order = Order::create([
        'order_no' => $order_no,
        'user_id' => $user_id,
        'fname' => $request->fname,
        'lname' => $request->lname,
        'cname' => $request->cname,
        'trn_no' => $request->trn_no,
        'email' => $request->email,
        'phone' => $request->phone,
        'altphone' => $request->altphone,
        'address' => $request->address,
        'city_id' => $request->city,
        'landmark' => $request->landmark
      ]);
      
      $carts = Helper::cartItems();
      $subtotal = Helper::cartSubtotal();
      $tax = Helper::cartTax();
      $discount = Helper::cartDiscount();
      $total = Helper::cartTotal();
      
      $city = City::with('state', 'country')->find($request->city);

      if($total > 100)
        $shipping = 0;
      else {
        $shipping = $city->shipping;
        $total += $shipping;
      }
      
      $payment = Payment::create([
        'order_id' => $order->id,
        'account_name' => $request->account_name,
        'method' => $request->pay_mthd,
        'subtotal' => $subtotal,
        'tax' => $tax,
        'shipping' => $shipping,
        'discount' => $discount,
        'total' => $total
      ]);
      
      if($request->pay_mthd == 'op') {
        $req = Request::create([
          'order_id' => $order->id,
          'account_name' => $request->account_name,
          'account_no' => $request->account_no,
          'expiry_month' => $request->expiry_month,
          'expiry_year' => $request->expiry_year,
          'cvv_cvc' => $request->cvv_cvc,
          'total' => $total
        ]);

        $response = (new StripeController)->payment($req);
        $pay = $response[0];

        if($pay) {
          $payment->charge = $pay->id;
          $payment->account_no = $pay->source->last4;
          if($pay->status == 'succeeded') {
            $payment->status = 'paid';
          }
        } else {
          $order->deleteQuietly();
          return back()->with('error', $response[1]);
        }
      }

      $payment->saveQuietly();

      if($request->pay_mthd == 'cod') {
        $cod = $total;
      } else {
        $cod = 0;
      }
      
      $awb = 123;
      
      if($request->shipping_option == 'different') {
        $shippings = Shipping::create([
          'order_id' => $order->id,
          'awb_no' => $awb,
          'fname' => $request->shipping_fname,
          'lname' => $request->shipping_lname,
          'phone' => $request->shipping_phone,
          'altphone' => $request->shipping_altphone,
          'address' => $request->shipping_address,
          'city_id' => $request->shipping_city,
          'landmark' => $request->shipping_landmark,
          'ordered' => $current_date
        ]);
      } else {
        $shippings = Shipping::create([
          'order_id' => $order->id,
          'awb_no' => $awb,
          'fname' => $request->fname,
          'lname' => $request->lname,
          'cname' => $request->cname,
          'trn_no' => $request->trn_no,
          'phone' => $request->phone,
          'altphone' => $request->altphone,
          'address' => $request->address,
          'city_id' => $request->city,
          'landmark' => $request->landmark,
          'ordered' => $current_date
        ]);
      }
        
      foreach($carts as $cart) {
        $order_item = OrderItem::create([
          'order_id' => $order->id,
          'attr_id' => $cart->attr_id,
          'quantity' => $cart->quantity,
          'subtotal' => $cart->subtotal,
          'tax' => $cart->tax,
          'total' => $cart->total
        ]);

        if($user_id) {
          $order_item->discount = $cart->discount;
          $order_item->coupon_id = $cart->coupon_id;
          $order->coupon_id = $cart->coupon_id;
          $order->saveQuietly();
        }
        $order_item->saveQuietly();
      }

      $req = new Request;
      $sale_pdf = (new OrderController)->saleInvoice($req, $order);  
      Mail::mailer('order')->to($request->email)->bcc('order@herbalcare.ae')->send(new OrderConfirmed($order, $sale_pdf));

      if($user_id) {  
        CartItem::where('user_id', $user_id)->delete();
      } else {
        $request->session()->forget(['id', 'cart']);
      }
      
      return back()->with(['order_success' => true, 'order_no' => $order->order_no]);
    }
}
