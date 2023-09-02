<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\FixedBanner;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Attribute;
use App\Models\ProductForm;
use App\Models\SubCategory;
use App\Models\User;
use Auth;
use Session;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use SendsPasswordResetEmails;

class FrontendController extends Controller
{
  public function home()
  {
    $banners = Banner::where('status', 'active')->inRandomOrder()->get();
    $fixed_banners = FixedBanner::get();
    $pop_products = Product::where('status', 'active')->whereRelation('promotions', 'name', 'popular')->orderBy('name')->get();
    $trn_products = Product::where('status', 'active')->whereRelation('promotions', 'name', 'trending')->inRandomOrder()->get();
    $new_products = Product::where('status', 'active')->whereRelation('promotions', 'name', 'new')->latest()->get();
      
    return view('main.index')->with(['banners' => $banners, 'fixed_banners' => $fixed_banners, 'pop_products' => $pop_products, 'trn_products' => $trn_products, 'new_products' => $new_products]);
  }

  public function productDetail($slug)
  {
    $product = Product::with('cats')->where(['slug' => $slug, 'status' => 'active'])->first();
    $relcats = $product->cats->pluck('name');

    $relproducts = Product::where('status', 'active')->whereHas('cats', function (Builder $query) use ($relcats) {
    $query->whereIn('name', $relcats);})->inRandomOrder()->take(10)->get();

    return view('main.pages.product-detail')->with('product', $product)->with('relproducts', $relproducts);
  }

  public function products(Request $request) {
    $products = Product::where('status', 'active')->orderBy('minprice')->get();

    return view('main.pages.shop-products')->with(['products' => $products, 'slug' => null, 'subslug' => null, 'search' => null, 'que' => null]);
  }

  public function catProducts(Request $request) {
    $products = Product::where('status', 'active')->whereRelation('cats', 'slug', $request->slug)->orderBy('minprice')->get();

    return view('main.pages.shop-products')->with(['products' => $products, 'slug' => $request->slug, 'subslug' => null, 'search' => null, 'que' => null]);
  }

  public function subcatProducts(Request $request){
    $products = Product::where('status', 'active')->whereRelation('subcats', 'slug', $request->subslug)->orderBy('minprice')->get();

    return view('main.pages.shop-products')->with(['products' => $products, 'slug' => $request->slug, 'subslug' => $request->subslug, 'search' => null, 'que' => null]);
  }

  public function searchProducts(Request $request) {
    $products = Product::where('status', 'active')->where(function(Builder $query) use ($request) {
      $query->where('name', 'like', '%'.$request->search.'%')->orwhere('sci_name', 'like', '%'.$request->search.'%')->orwhere('other_name', 'like', '%'.$request->search.'%');
    })->orderBy('minprice')->get();

    return view('main.pages.shop-products')->with(['products' => $products, 'slug' => null, 'subslug' => null, 'search' => 1, 'que' => $request->search]);
  }

  public function sortProducts(Request $request) {
    $sort_by = $request->value;
    if($request->search) {
      if(in_array($sort_by, ['popular', 'trending', 'new']))
        $products = Product::where('status', 'active')->where(function(Builder $query) use ($request) {
          $query->where('name', 'like', '%'.$request->que.'%')->orwhere('sci_name', 'like', '%'.$request->que.'%')->orwhere('other_name', 'like', '%'.$request->que.'%');
        })->whereRelation('promotions', 'name', $sort_by)->orderBy('minprice')->get();
      else
        $products = Product::where('status', 'active')->where(function(Builder $query) use ($request) {
          $query->where('name', 'like', '%'.$request->que.'%')->orwhere('sci_name', 'like', '%'.$request->que.'%')->orwhere('other_name', 'like', '%'.$request->que.'%');
        })->get();
    } else if ($request->subslug) {
      if(in_array($sort_by, ['popular', 'trending', 'new']))
        $products = Product::where('status', 'active')->whereRelation('subcats', 'slug', $request->subslug)->whereRelation('promotions', 'name', $sort_by)->orderBy('minprice')->get();
      else
        $products = Product::where('status', 'active')->whereRelation('subcats', 'slug', $request->subslug)->get();
    } else if ($request->slug) {
      if(in_array($sort_by, ['popular', 'trending', 'new']))
        $products = Product::where('status', 'active')->whereRelation('cats', 'slug', $request->slug)->whereRelation('promotions', 'name', $sort_by)->orderBy('minprice')->get();
      else
        $products = Product::where('status', 'active')->whereRelation('cats', 'slug', $request->slug)->get();
    } else {
      if(in_array($sort_by, ['popular', 'trending', 'new']))
        $products = Product::where('status', 'active')->whereRelation('promotions', 'name', $sort_by)->orderBy('minprice')->get();
      else
        $products = Product::where('status', 'active')->get();
    }

    if (! in_array($sort_by, ['popular', 'trending', 'new'])) {
      if($sort_by == 'rand')
        $products = $products->sortBy('id');
      else if($sort_by == 'a-z')
        $products = $products->sortBy('name');
      else if($sort_by == 'z-a')
        $products = $products->sortByDesc('name');
      else if($sort_by == 'low-prc')
        $products = $products->sortBy('minprice');
      else if($sort_by == 'hgh-prc')
        $products = $products->sortByDesc('minprice');
    }

    if ($products->isNotEmpty()) {
      $content = '';

      foreach ($products as $product) {
        $minprice = $product->attrs()->min('price');;
        $maxprice = $product->attrs()->max('price');
        
        if(Auth::check())
          $wishlist = $product->wishlists()->where('user_id', Auth::user()->id)->get();

        $minprice = number_format($minprice, 2);
        $maxprice = number_format($maxprice, 2);

        $content .= <<<EOD
          <div class="product-card {$product->id}-card carousel-cell">
          <img class="product-image" src="{$product->photo}" alt="product image">
          
          <div class="overlay">
            <button id="product-{$product->id}" class="btn btn-quick-view" title="Quick View" onclick="showModal(id, {$product->id})"> 
              <i class="fa-regular fa-eye"></i>
              <p>Quick View</p>
            </button>
          </div>

          <div class="meta-detail">
            <h3 class="product-title">{$product->name}</h3>
        EOD;

        if($product->minprice == $maxprice) {
          $content .= <<<EOD
            <p class="price">AED <span class="value">{$minprice}</span></p>
          EOD;
        } else {
          $content .= <<<EOD
            <p class="price">AED <span class="value">{$minprice}</span> - AED <span class="value">{$maxprice}</span></p>
          EOD;
        }

        $content .= <<<EOD
            </div>

            <div class="prod-detail-link">
              <a href="/product-detail/{$product->slug}" class="btn btn-submit detail-link"> Product Details </a>
        EOD;

        if(Auth::user()) {
          if($wishlist->isNotEmpty()) {
            $content .= <<<EOD
                <button class="btn favbtn" onclick="fav(this, {$product->id})"><i class="fa-solid fa-heart fav"></i></button>
                </div>
              </div>
              EOD;
          }
          else {
            $content .= <<<EOD
                <button class="btn favbtn" onclick="fav(this, {$product->id})"><i class="fa-regular fa-heart fav"></i></button>
                </div>
              </div>
              EOD;
          }
        }

        else {
          $content .= <<<EOD
                  <button class="btn favbtn" onclick="window.location.href = 'user/login';"><i class="fa-regular fa-heart fav"></i></button>
                </div>
              </div>
            EOD;
        }
      } 
    } else {

      $content = <<<EOD
        <p class="no-product">There is no product in this criteria.</p>
      EOD;
    }
    return $content;
  }

  public function logout(){
    Session::forget('user');
    Auth::logout();
    request()->session()->flash('success','Logout successfully');
    return back();
  }

  public function resetPasswordView(Request $request){
    return view('auth.passwords.reset')->with('request', $request);
  }

  public function productPrice(Request $request) {
    if(! $request->form)
      $attr = Attribute::where('product_id', $request->id)->where('size', $request->size)->first();   
    else
      $attr = Attribute::where('product_id', $request->id)->where('size', $request->size)->where('form_id', $request->form)->first();   
    return $attr->price;
  }

  public function autocompleteSearch(Request $request) {
    $data = array();
    $products = Product::where('status', 'active')->get();
    foreach($products as $product) {
      array_push($data, $product->name);
      array_push($data, $product->sci_name);
      $results = explode('^', $product->other_name);
      foreach ($results as $result) {
        array_push($data, $result);
      }
    }

    $data = array_filter($data, function($value) { return !is_null($value) && $value !== '' && $value !== ' '; });
    $data = array_unique($data);
    $data = array_map('trim', $data);
    sort($data);
    echo json_encode($data);
  }

  public function existsUser(Request $request) {
    if($request->email) {
      $user = User::where('email', $request->email)->first();
      if($user) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
}
