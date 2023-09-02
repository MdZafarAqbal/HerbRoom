@extends('main.layouts.master')

@php
  $cats = Helper::categories();
  if($slug) {
    $category = $cats->where('slug', $slug)->first();
  }
  if(!$subslug and $slug) {
    $title = $category->name;
  } else if ($subslug) {
    $subcategory = $category->subcats()->where('slug', $subslug)->first();
    $title = $subcategory->name;
  } else if ($que) {
    $title = "Search - " . $que;
  } else {
    $title = "Products";
  }
@endphp

@section('title') {{$title}} Products || HerbalCare @endsection

@push('vendor_styles')
  <link rel="stylesheet" href="{{asset('css/vendor/exzoom.min.css')}}">
@endpush

@push('styles')
  <link href="{{asset('css/main/products.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/main/modal.min.css')}}" rel="stylesheet">
@endpush

@push('vendor_scripts')
  <script src="{{asset('js/vendor/exzoom.min.js')}}" defer></script>
@endpush

@section('main-content')
  <div class="page-header">
    <h1>{{$title}}</h1>

    <div class="sorts product-sorts" id="product-sorts">
      <span>Sort by: </span>
      <span id="selected-sort" class="selected-sort dropdown-toggle">Low Price <i class="fa-sharp fa-solid fa-caret-down fa-beat"></i></span>
      <ul id="sorting-list" class="sorting-list collapse">
        <li class="sort-list-item" data="rand" onclick="sort(this, '{{$slug}}', '{{$subslug}}', '{{$search}}', '{{$que}}')">Random</li>
        <li class="sort-list-item" data="a-z" onclick="sort(this, '{{$slug}}', '{{$subslug}}', '{{$search}}', '{{$que}}')">A to Z</li>
        <li class="sort-list-item" data="z-a" onclick="sort(this, '{{$slug}}', '{{$subslug}}', '{{$search}}', '{{$que}}')">Z to A</li>
        <li class="selected sort-list-item" data="low-prc" onclick="sort(this, '{{$slug}}', '{{$subslug}}', '{{$search}}', '{{$que}}')">Low Price</li>
        <li class="sort-list-item" data="hgh-prc" onclick="sort(this, '{{$slug}}', '{{$subslug}}', '{{$search}}', '{{$que}}')">High Price</li>
        <li class="sort-list-item" data="new" onclick="sort(this, '{{$slug}}', '{{$subslug}}', '{{$search}}', '{{$que}}')">New</li>
        <li class="sort-list-item" data="popular" onclick="sort(this, '{{$slug}}', '{{$subslug}}', '{{$search}}', '{{$que}}')">Popular</li>
        <li class="sort-list-item" data="trending" onclick="sort(this, '{{$slug}}', '{{$subslug}}', '{{$search}}', '{{$que}}')">Trending</li>
      </ul>
    </div>
  </div>

  @if(!$subslug and $slug)
    <p class="bread-crumbs"><a href="{{route('home')}}">Home</a> / <a href="{{route('products')}}">Products</a> / <a href="{{route('cat.products', ['slug' => $slug])}}">{{$category->name}}</a></p>
  @elseif ($subslug)
    <p class="bread-crumbs"><a href="{{route('home')}}">Home</a> / <a href="{{route('products')}}">Products</a> / <a href="{{route('cat.products', ['slug' => $slug])}}">{{$category->name}}</a> / <a href="{{route('subcat.products', ['slug' => $slug, 'subslug' => $subslug])}}">{{$subcategory->name}}</a></p>
  @elseif ($que)
    <p class="bread-crumbs"><a href="{{route('home')}}">Home</a> / <a href="{{route('products')}}">Products</a> / <a href="{{route('product.search', ['search' => $que])}}">Search: {{$que}}</p>
  @else
    <p class="bread-crumbs"><a href="{{route('home')}}">Home</a> / <a href="{{route('products')}}">Products</a></p>
  @endif

  <section class="products-catalog">
    <!-- Side Menu -->
    @if($cats->isNotEmpty())
      <div class="products-sidebar">
        <div class="categories-menu">
          <h3 class="title">Categories</h3>
          <ul class="cat-list">
            @foreach($cats as $cat)
              @php
                $subcats = $cat->subcats()->get();
              @endphp
              
              @if($subcats->isNotEmpty())
                @if(!$subslug and $slug == $cat->slug)
                  <li class="dropdown-toggle active">
                    <a href="{{route('cat.products', $cat->slug)}}">{{$cat->name}}</a>
                    <button class="btn btn-dropdown"><i class="fa-sharp fa-solid fa-caret-down fa-beat"></i></button>
                  </li>
                @else
                  <li class="dropdown-toggle">
                    <a href="{{route('cat.products', $cat->slug)}}">{{$cat->name}}</a>
                    <button class="btn btn-dropdown"><i class="fa-sharp fa-solid fa-caret-down fa-beat"></i></button>
                  </li>
                @endif
                <ul class="subcat">
                  @foreach($subcats as $subcat)
                    @if ($subslug == $subcat->slug)
                      <li class="active"><a href="{{route('subcat.products', [$cat->slug, $subcat->slug])}}">{{$subcat->name}}</a></li>
                    @else
                      <li><a href="{{route('subcat.products', [$cat->slug, $subcat->slug])}}">{{$subcat->name}}</a></li>
                    @endif
                  @endforeach
                </ul>
              @else
                @if($slug == $cat->slug)
                  <li class="active"><a href="{{route('cat.products', $cat->slug)}}">{{$cat->name}}</a></li>
                @else
                  <li><a href="{{route('cat.products', $cat->slug)}}">{{$cat->name}}</a></li>
                @endif
              @endif
            @endforeach
          </ul>
        </div>
      </div>
    @endif
    <!-- End Sidebar -->
  
    <div id="products-catalog" class="products catalog">
      @if($products->isNotEmpty())
        @foreach($products as $product)
          @php
            $minprice = $product->attrs()->min('price');
            $maxprice = $product->attrs()->max('price');

            if(Auth::check())
              $wishlist = $product->wishlists()->where('user_id', Auth::user()->id)->get();
          @endphp

              <div class="product-card {{$product->id}}-card carousel-cell">
              <img class="product-image" src="{{$product->photo}}" alt="product image">
              
              <div class="overlay">
                <button id="product{{$product->id}}" class="btn btn-quick-view" title="Quick View" onclick="showModal(id, {{$product->id}})"> 
                  <i class="fa-regular fa-eye"></i>
                  <p>Quick View</p>
                </button>
              </div>

              <div class="meta-detail">
                <h3 class="product-title">{{$product->name}}</h3>
                @if($minprice==$maxprice)
                  <p class="price">AED <span class="value">{{number_format($product->minprice,2)}}</span></p>
                @else
                  <p class="price">AED <span class="value">{{number_format($product->minprice,2)}}</span> - AED <span class="value">{{number_format($maxprice,2)}}</span></p>
                @endif                  
              </div>
              <div class="prod-detail-link">
                  <a href="{{route('product.detail', $product->slug)}}" class="btn btn-submit detail-link"> Product Details </a>
                  @auth
              @if(count($wishlist) != 0)
                <button class="btn favbtn" onclick="fav(this, {{$product->id}})"><i class="fa-solid fa-heart fav"></i></button>
              @else
                <button class="btn favbtn" onclick="fav(this, {{$product->id}})"><i class="fa-regular fa-heart fav"></i></button>
              @endif
            @else
              <button class="btn favbtn" onclick="window.location.href = '/login';"><i class="fa-regular fa-heart fav"></i></button>
            @endauth
              </div>
            </div>
          @endforeach
      @else
        <p class="no-product">There is no product in this category.</p>
      @endif
    </div>
    <div class="modal-container" id="modal-container"></div>
    <section id="checkout-popup" class="checkout-popup">
      <div id="location-popup" class="ch-popup" data-toggle="0">
        <button type="button" class="btn close close-inner" id="inner-close-btn" onclick="remInnerModal()">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <button id="page-loc-btn" class="btn btn-submit popup-btn loc-btn" onclick="remInnerModal()">Stay on Page</button>
        @auth
          <button id="chkt-loc-btn" class="btn btn-submit popup-btn loc-btn" onclick="location.href = '/checkout'">Checkout</button>
        @else
          <button id="chkt-loc-btn" class="btn btn-submit popup-btn loc-btn" onclick="chOptions()">Checkout</button>
          <button id="guest-chkt-btn" class="btn btn-submit popup-btn chkt-btn collapse" onclick="location.href = '/checkout'">Checkout as Guest</button>
          <button id="login-chkt-btn" class="btn btn-submit popup-btn chkt-btn collapse" onclick="location.href = '/login?checkout=1'">Login to Checkout</button>
        @endauth
      </div>
    </section>
  </section>
@endsection

@push('scripts')
  <script src="{{asset('js/main/products.min.js')}}"></script>
  <script src="{{asset('js/main/modal.min.js')}}"></script>
  <script>
    $(function() {
      /* Show sorting menu*/
      $('#selected-sort').click(() => {
        $('#sorting-list').toggleClass('collapse');
      })
    });
  </script>
@endpush