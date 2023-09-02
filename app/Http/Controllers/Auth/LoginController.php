<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles authenticating users for the application and
  | redirecting them to your home screen. The controller uses a trait
  | to conveniently provide its functionality to your applications.
  |
  */

  use AuthenticatesUsers;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  public function loginView(Request $request) {
    return view('auth.login')->with('checkout', $request->checkout);
  }
    
  public function login(Request $request): RedirectResponse
  {
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
      $cart_items = session('cart');

      foreach($cart_items as $item) {
        $attr = Attribute::with('product.cats', 'product.subcats')->find($item->attr_id);
        $already_cart = CartItem::with('coupon')->where(['user_id' => $request->user()->id, 'attr_id' => $attr->id])->first();
        $order = Order::where('user_id', $request->user()->id)->first();
        $discount = 0;
  
        if ($already_cart) {
          $already_cart->quantity += $item->quantity;
          $already_cart->total = $attr->price * $already_cart->quantity;
          $already_cart->subtotal = $already_cart->total / 1.05;
          $total = $already_cart->subtotal;
  
          if(! $order) {
            $discount += $total / 10;
            $total -= $discount;
          }
  
          if($already_cart->coupon) {
            if($already_cart->coupon->type == 'percent') {
              $coupon_discount = $total * $already_cart->coupon->value / 100;
              $discount += $coupon_discount;
              $total -= $coupon_discount;
            }
          }
          
          $already_cart->tax = $total * 0.05;
          $already_cart->discount = $discount;
          $already_cart->total = $total + $already_cart->tax;
          $already_cart->save();
  
        } else {
          $carts = CartItem::with('coupon')->where('user_id', $request->user()->id)->get();
          $coupon = null;
          $discount = 0;
  
          foreach($carts as $cart_item) {
            if($cart_item->coupon) {
              $coupon = $cart_item->coupon;
            }
          }
  
          $cart = new CartItem;
          $cart->user_id = $request->user()->id;
          $cart->attr_id = $item->attr_id;
          $cart->quantity = $item->quantity;
          $cart->total = $attr->price * $cart->quantity;
          $cart->subtotal = $cart->total / 1.05;
          $total = $cart->subtotal;
          
          if(!$order) {
            $discount += $total / 10;
            $total -= $discount;
          }
  
          if($coupon) {
            if($coupon->effect == 'product') {
              if($attr->product->coupon_id == $coupon->id) {
                if($coupon->type == 'percent')
                  $coupon_discount = $total * $coupon->value / 100;
              }
            } elseif($coupon->effect == 'category') {
              foreach($attr->product->cats as $cat) {
                if($cat->coupon_id == $coupon->id) {
                  if($coupon->type == 'percent')
                    $coupon_discount = $total * $coupon->value / 100;
                }
              }
            } elseif($coupon->effect == 'subcategory') {
              foreach($attr->product->subcats as $subcat) {
                if($subcat->coupon_id == $coupon->id) {
                  if($coupon->type == 'percent')
                    $coupon_discount = $total * $coupon->value / 100;
                }
              }
            } elseif($coupon->effect == 'user') {
              if($request->user()->coupon_id == $coupon->id) {
                if($coupon->type == 'percent')
                  $coupon_discount = $total * $coupon->value / 100;
              }
            } elseif($coupon->effect == 'all') {
              if($coupon->type == 'percent')
                $coupon_discount = $total * $coupon->value / 100;
            } else {
              $coupon_discount = 0;
            }

            $discount += $coupon_discount;
            $total -= $coupon_discount;
            $cart->coupon_id = $coupon->id;
          }
  
          $cart->tax = $total * 0.05;
          $cart->discount = $discount;
          $cart->total = $total + $cart->tax;
          $cart->save();
        }
      }

      $request->session()->forget(['id', 'cart']);
      $request->session()->regenerate();

      $request->session()->put('user', $request->email);
      if($request->user()->cname)
        $request->session()->put('cname', $request->user()->cname);
      else {
        $request->session()->put('fname', $request->user()->fname);
        $request->session()->put('lname', $request->user()->lname);
      }

      if($request->checkout)
        return redirect()->route('checkout');

      return redirect()->intended(RouteServiceProvider::HOME);
    } else {
      return redirect()->back()->with('error','Incorrect password. Please try again!');
    }
  }
}
