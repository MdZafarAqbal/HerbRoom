<?php
use App\Models\CartItem;
use App\Models\Category;
use App\Models\City;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use App\Models\Wishlist;

class Helper
{
  // Get all product categories
  public static function categories()
  {
    $categories = Category::where('status', 'active')->get();
    return $categories;
  }

  // Cart Count
  public static function cartCount() {
    if(Auth::check()) {
      $user_id=auth()->user()->id;
      return CartItem::where('user_id',$user_id)->count('product_id');
    }
    else {
      return 0;
    }
  }

  // Favorites Count
  public static function favCount() {
    if(Auth::check()) {
      $user_id=auth()->user()->id;
      return Wishlist::where('user_id',$user_id)->count('product_id');
    }
    else {
      return 0;
    }
  }

  public static function cartItems()
  {
    if (Auth::check()) {
      return CartItem::where('user_id', auth()->user()->id)->get();
    } else {
      $cart = Session::get('cart');
      return $cart;
    }
  }

  //Total cart amount without tax
  public static function cartSubtotal()
  {
    if (Auth::check()) {
      $user_id = auth()->user()->id;
      return CartItem::where('user_id', $user_id)->sum('subtotal');
    } else {
      $cart_items = Session::get('cart');
      $sum = 0;

      foreach ($cart_items as $item) {
        $sum += $item->subtotal;
      }

      return $sum;
    }
  }

  // Total cart tax
  public static function cartTax() {
    if (Auth::check()) {
      $user_id = auth()->user()->id;
      return CartItem::where('user_id', $user_id)->sum('tax');
    } else {
      $cart_items = Session::get('cart');
      $sum = 0;

      foreach ($cart_items as $item) {
        $sum += $item->tax;
      }
      return $sum;
    }
  }

  // Total cart tax
  public static function cartDiscount()
  {
    if (Auth::check()) {
      $user_id = auth()->user()->id;
      return CartItem::where('user_id', $user_id)->sum('discount');
    } else {
      return 0;
    }
  }

  // Total cart amount with tax
  public static function cartTotal()
  {
    if (Auth::check()) {
      $user_id = auth()->user()->id;
      return CartItem::where('user_id', $user_id)->sum('total');
    } else {
      $cart_items = Session::get('cart');
      $sum = 0;

      foreach ($cart_items as $item) {
        $sum += $item->total;
      }

      return $sum;
    }
  }
}
?>