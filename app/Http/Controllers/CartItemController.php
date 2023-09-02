<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Helper;
use Session;

class CartItemController extends Controller
{
  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'product_id' => 'required',
      'price' => 'required',
      'size' => 'required',
      'qty' => 'required',
    ]);

    $product = Product::with('cats', 'subcats')->find($request->product_id);
    if($request->form_id) {
      $attr = Attribute::with('form')->where('product_id', $request->product_id)->where('form_id', $request->form_id)->where('size', $request->size)->first();
    } else {
      $attr = Attribute::with('form')->where('product_id', $request->product_id)->where('size', $request->size)->first();
    }

    if ($request->qty < 1) {
      return response()->json('Invalid Quantity Value. Quantity must be positive integer', 400);
    } else if (empty($product)) {
      return response()->json('Invalid Product. No such product', 400);
    } else if (Auth::check()) {
      $already_cart = CartItem::with('coupon')->where(['user_id' => $request->user()->id, 'attr_id' => $attr->id])->first();
      $order = Order::where('user_id', $request->user()->id)->first();
      $discount = 0;

      if ($already_cart) {
        $already_cart->quantity += $request->qty;
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
        $cart->attr_id = $attr->id;
        $cart->quantity = $request->qty;
        $cart->total = $attr->price * $cart->quantity;
        $cart->subtotal = $cart->total / 1.05;
        $total = $cart->subtotal;
        
        if(!$order) {
          $discount += $total / 10;
          $total -= $discount;
        }

        if($coupon) {
          if($coupon->effect == 'product') {
            if($product->coupon_id == $coupon->id) {
              if($coupon->type == 'percent')
                $coupon_discount = $total * $coupon->value / 100;
            }
          } elseif($coupon->effect == 'category') {
            foreach($product->cats as $cat) {
              if($cat->coupon_id == $coupon->id) {
                if($coupon->type == 'percent')
                  $coupon_discount = $total * $coupon->value / 100;
              }
            }
          } elseif($coupon->effect == 'subcategory') {
            foreach($product->subcats as $subcat) {
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
      
    } else {
      $already_cart = 0;
      if ($request->session()->has('cart')) {
        $carts = session('cart');
  
        foreach ($carts as $cart_item) {
          if ($cart_item->attr_id == $attr->id) {
            $already_cart = 1;
            $quantity = $request->qty;
            $total = $attr->price * $quantity;
            $subtotal = $total / 1.05;
            $tax = $total - $subtotal;
            $cart_item->quantity += $quantity;
            $cart_item->total += $total;
            $cart_item->subtotal += $subtotal;
            $cart_item->tax += $tax;
          }
        }
      }

      if ($already_cart == 0) {
        $request->session()->increment('id');
        $cart = new CartItem;
        $cart->id = session('id');
        $cart->attr_id = $attr->id;
        $cart->quantity = $request->qty;
        $cart->total = $attr->price * $cart->quantity;
        $cart->subtotal = $cart->total / 1.05;
        $cart->tax = $cart->total - $cart->subtotal;
        $request->session()->push('cart', $cart);
      }
    }

    $carts = Helper::cartItems();
    $count = count(Helper::cartItems());
    $total = number_format(Helper::cartTotal(), 2);
    $content = '';
    foreach($carts as $cart) {
      $price = number_format($cart->attr->price, 2);
      $content .= <<<EOD
        <li>
          <div class="product-det">
            <h4><a class="prod-name" href="/product-detail/{$cart->attr->product->slug}" target="_blank">{$cart->attr->product->name}</a></h4>
            <p class="font">
      EOD;

      if($cart->attr->form_id) {
        $content .= <<<EOD
          {$cart->attr->form->name} - 
        EOD;
      }
      
      $content .= <<<EOD
      {$cart->attr->size} {$cart->attr->unit}</p>
            <p class="font">$cart->quantity x $price AED</p>
            <a href="/cart-delete/$cart->id" class="remove font" title="Remove"><i class="fa-regular fa-trash-can"></i> Remove Item</a>
          </div>
          <a class="cart-img" href="#"><img src="{$cart->attr->product->photo}" alt="product photo"></a>
        </li>
      EOD;
    }
    return [$count, $content, $total];
  }
 
  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $cart_item)
  {
    $discount = 0;
    if (Auth::check()) {
      $cart = CartItem::with('coupon')->find($cart_item);
      $order = Order::where('user_id', auth()->user()->id)->first();
      
      $cart->quantity = $request->qty;
      $cart->total = $cart->attr->price * $request->qty;
      $cart->subtotal = $cart->total / 1.05;
      $total = $cart->subtotal;

      if (!$order) {
        $discount += $total / 10;
        $total -= $discount;
      }

      if($cart->coupon) {
        if($cart->coupon->type == 'percent') {
          $coupon_discount = $total * $cart->coupon->value / 100;
          $discount += $coupon_discount;
          $total -= $coupon_discount;
        }
      }
      
      $cart->tax = $total * 0.05;
      $cart->discount = $discount;
      $cart->total = $total + $cart->tax;
      $cart->save();
      $total = $cart->total;

    } else {
      $carts = $request->session()->get('cart');

      foreach ($carts as $cart) {
        if($cart->id == $cart_item) {
          $cart->quantity = $request->qty;
          $cart->total = $cart->attr->price * $request->qty;
          $cart->subtotal = ($cart->total) / 1.05;
          $cart->tax = $cart->total - $cart->subtotal;

          $total = $cart->total;
        }
      }

      $request->session()->forget('cart');
      $request->session()->put('cart', $carts);
    }

    $subtotal = Helper::cartSubtotal();
    $tax = Helper::cartTax();
    $cartDiscount = Helper::cartDiscount();
    $totalAmount = Helper::cartTotal();
    return [$discount, $total, $subtotal, $tax, $cartDiscount, $totalAmount];
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    if(Auth::check()) {
      $cart = CartItem::find($id);
      $cart->delete();
      return back();
    }
    else {
      $carts = Session::get('cart');
      $found = null; 

      foreach ($carts as $key => $item) {
        if($item->id == $id) {
          $found = $key;
        }
      }

      Session::pull('cart');

      if ($found !== null) 
        unset($carts[$found]);

      Session::put('cart', $carts);
      return back();
    }
  }
}