<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\ProductAttribute;

class WishlistController extends Controller
{
    protected $product = null;
    public function __construct(Product $product){
        $this->product = $product;
    }

    public function index() {
      $wishlists = new Collection();
      if (Auth::check())
        $wishlists = Wishlist::with('product')->where('user_id', Auth::user()->id)->get();
      return view('main.pages.wishlist')->with('wishlists', $wishlists);
    }

    public function store(Request $request) {
      $request->validate([
        'id' => 'required',
      ]);

      $product = Product::where('id', $request->id)->first();
      $userId = auth()->user()->id;
        
      $wishlist = new Wishlist;
      $wishlist->user_id = $userId;
      $wishlist->product_id = $request->id;

      $wishlist->save();

      $favCounts = Wishlist::where('user_id', $userId)->count('product_id');

      return $favCounts;
    }  
          
    public function destroy(Request $request, $productId) {
      $wishlist = Wishlist::where('product_id', $productId)->delete();
      $favCounts = Wishlist::where('user_id', auth()->user()->id)->count('product_id');

      if($request->reload == 1) {
        return back();
      }

      return $favCounts;
    }     
}
