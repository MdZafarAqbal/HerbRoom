@extends('main.layouts.master')
@section('title', 'HerbalCare - Botanical World of Herbs || Shop Herbs, Teas, Oils and Extracts')

@push('vendor_styles')
  <link rel="stylesheet" href="{{asset('css/vendor/exzoom.min.css')}}">
@endpush

@push('styles')
  <link rel="stylesheet" href="{{asset('css/main/index.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/main/modal.min.css')}}">
@endpush

@push('vendor_scripts')
  <script src="{{asset('js/vendor/exzoom.min.js')}}" defer></script>
@endpush

@section('main-content')
  @php
    $cats = Helper::categories();
  @endphp
  <!-- <video src="{{asset('images/bannert.mp4')}}" autoplay muted loop></video> -->

  @if ($banners)
    <section id="slider" class="slider">         
      <ul id="carousel-wrap" class="carousel-wrap">
        @foreach($banners as $banner)                                    
          <li>
            <picture>
              <source media="(min-width: 768px)" srcset="{{$banner->photo_desktop}}">
              <source media="(min-width: 480px)" srcset="{{$banner->photo_tablet}}">
              <img class="slide-img" src="{{$banner->photo_mobile}}" alt="Slider Image">
            </picture>
          </li>
        @endforeach
      </ul>

      <a href="#" id="slide-prev">&lt;</a>
      <a href="#" id="slide-next">&gt;</a>
    </section>
  @endif

  <section class="products-catalog">
    @php
      $auth = Auth::check();
    @endphp

    @if($pop_products->isNotEmpty())
      <div class="products">
        <h2 class="cat-title"> Popular Items </h2>
      
        <div class="product-slider carousel hero-slider"  data-flickity='{ "contain": true, "pageDots": false, "autoPlay": 3000}'>
          @foreach($pop_products as $product)
            @php
              $minprice = $product->attrs()->min('price');
              $maxprice = $product->attrs()->max('price');            

              if($auth)
                $wishlist = $product->wishlists()->where('user_id', Auth::user()->id)->get();
            @endphp
            <div class="product-card {{$product->id}}-card carousel-cell">
              <img class="product-image" src="{{$product->photo}}" alt="product image">
              
              <div class="overlay">
                <button id="pop{{$product->id}}" class="btn btn-quick-view" title="Quick View" onclick="showModal(id, {{$product->id}})"> 
                  <i class="fa-regular fa-eye"></i>
                  <p>Quick View</p>
                </button>
              </div>

              <div class="meta-detail">
                <h4 class="card-product-title">{{$product->name}}</h4>
                @if($minprice==$maxprice)
                  <p class="price">AED <span class="value">{{number_format($minprice,2)}}</span></p>
                @else
                  <p class="price">AED <span class="value">{{number_format($minprice,2)}}</span> - AED <span class="value">{{number_format($maxprice,2)}}</span></p>
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
                  <button class="btn favbtn" onclick="window.location.href = '/login'"><i class="fa-regular fa-heart fav"></i></button>
                @endauth
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    @if($trn_products->isNotEmpty())
      <div class="products">
        <h2 class="cat-title"> Trending Items </h2>
      
        <div class="product-slider carousel hero-slider"  data-flickity='{ "contain": true, "pageDots": false, "autoPlay": 3000}'>
          @foreach($trn_products as $product)
            @php
              $minprice = $product->attrs()->min('price');
              $maxprice = $product->attrs()->max('price'); 

              if($auth)
                $wishlist = $product->wishlists()->where('user_id', Auth::user()->id)->get();
            @endphp
            <div class="product-card {{$product->id}}-card carousel-cell">
              <img class="product-image" src="{{$product->photo}}" alt="product image">
              
              <div class="overlay">
                <button id="trn{{$product->id}}" class="btn btn-quick-view" title="Quick View" onclick="showModal(id, {{$product->id}})"> 
                  <i class="fa-regular fa-eye"></i>
                  <p>Quick View</p>
                </button>
              </div>

              <div class="meta-detail">
                <h4 class="card-product-title">{{$product->name}}</h4>
              @if($minprice==$maxprice)
                <p class="price">AED <span class="value">{{number_format($minprice,2)}}</span></p>
              @else
                <p class="price">AED <span class="value">{{number_format($minprice,2)}}</span> - AED <span class="value">{{number_format($maxprice,2)}}</span></p>
              @endif              </div>
              <div class="prod-detail-link">
                <a href="{{route('product.detail', $product->slug)}}" class="btn btn-submit detail-link"> Product Details </a>
                
                @auth
                  @if(count($wishlist) != 0)
                    <button class="btn favbtn" onclick="fav(this, {{$product->id}})"><i class="fa-solid fa-heart fav"></i></button>
                  @else
                    <button class="btn favbtn" onclick="fav(this, {{$product->id}})"><i class="fa-regular fa-heart fav"></i></button>
                  @endif
                @else
                  <button class="btn favbtn" onclick="window.location.href = 'user/login'"><i class="fa-regular fa-heart fav"></i></button>
                @endauth
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    @if($new_products->isNotEmpty())
      <div class="products">
        <h2 class="cat-title"> New Items </h2>
      
        <div class="product-slider carousel hero-slider"  data-flickity='{ "contain": true, "pageDots": false, "autoPlay": 3000}'>
          @foreach($new_products as $product)
            @php
              $minprice = $product->attrs()->min('price');
              $maxprice = $product->attrs()->max('price'); 

              if($auth)
                $wishlist = $product->wishlists()->where('user_id', Auth::user()->id)->get();
            @endphp
            <div class="product-card {{$product->id}}-card carousel-cell">
              <img class="product-image" src="{{$product->photo}}" alt="product image">
              
              <div class="overlay">
                <button id="new{{$product->id}}" class="btn btn-quick-view" title="Quick View" onclick="showModal(id, {{$product->id}})"> 
                  <i class="fa-regular fa-eye"></i>
                  <p>Quick View</p>
                </button>
              </div>

              <div class="meta-detail">
                <h4 class="card-product-title">{{$product->name}}</h4>
              @if($minprice==$maxprice)
                <p class="price">AED <span class="value">{{number_format($minprice,2)}}</span></p>
              @else
                <p class="price">AED <span class="value">{{number_format($minprice,2)}}</span> - AED <span class="value">{{number_format($maxprice,2)}}</span></p>
              @endif              </div>
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
        </div>
      </div>
    @endif

    @if($cats->isNotEmpty())
      <div class="fixed-banner-container">
        @php
          $fixed_upper = $fixed_banners->where('name', 'upper')->first();
        @endphp
        
        <picture>
          <source media="(min-width: 768px)" srcset="{{$fixed_upper->photo_desktop}}">
          <source media="(min-width: 480px)" srcset="{{$fixed_upper->photo_tablet}}">
          <img class="slide-img" src="{{$fixed_upper->photo_mobile}}" alt="Fixed Banner Image">
        </picture>
      </div>
      @foreach($cats as $cat)
        @php
          $product_cat = $cat->products()->where('status', 'active')->inRandomOrder()->limit(9)->get();
        @endphp

        @if($product_cat->isNotEmpty())
          <div class="products">
            <h2 class="cat-title"> {{$cat->name}} </h2>
          
            <div class="product-slider carousel hero-slider"  data-flickity='{ "contain": true, "pageDots": false }'>
              @foreach($product_cat as $product)
              @php
                $minprice = $product->attrs()->min('price');
                $maxprice = $product->attrs()->max('price');

                if($auth)
                  $wishlist = $product->wishlists()->where('user_id', Auth::user()->id)->get();
              @endphp
            <div class="product-card {{$product->id}}-card carousel-cell">
              <img class="product-image" src="{{$product->photo}}" alt="product image">
              
              <div class="overlay">
                <button id="cat{{$cat->id}}_{{$product->id}}" class="btn btn-quick-view" title="Quick View" onclick="showModal(id, {{$product->id}})"> 
                  <i class="fa-regular fa-eye"></i>
                      <p>Quick View</p>
                    </button>
                  </div>

                  <div class="meta-detail">
                    <h4 class="card-product-title">{{$product->name}}</h4>
                  @if($minprice==$maxprice)
                    <p class="price">AED <span class="value">{{number_format($minprice,2)}}</span></p>
                  @else
                    <p class="price">AED <span class="value">{{number_format($minprice,2)}}</span> - AED <span class="value">{{number_format($maxprice,2)}}</span></p>
                  @endif                  </div>
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
              <div class="product-card {{$product->id}}-card carousel-cell link-card">
                <a href="{{route('cat.products', $cat->slug)}}" class="view-link">View All</a>
              </div>
            </div>
          </div>
        @endif
      @endforeach
    @endif

    <div class="fixed-banner-container">
      @php
        $fixed_lower = $fixed_banners->where('name', 'lower')->first();
      @endphp

      <picture>
        <source media="(min-width: 768px)" srcset="{{$fixed_lower->photo_desktop}}">
        <source media="(min-width: 480px)" srcset="{{$fixed_lower->photo_tablet}}">
        <img class="slide-img" src="{{$fixed_lower->photo_mobile}}" alt="Fixed Banner Image">
      </picture>
    </div>

    <h2 class="center-title cat-title">Visit Our Stores</h2>

    <div class="store-carousel">
      <div class="store-card">
        <img class="store-img" src="{{asset('images/satwa.jpg')}}" alt="store image">

        <div class="meta-detail">
          <h3 class="card-store-title">SATWA</h3>
        </div>
        <div class="learn-more-link">
          <a href="{{route('contact')}}#satwa" class="btn btn-submit detail-link"> Learn More </a>
        </div>
      </div>
      <div class="store-card">
        <img class="store-img" src="{{asset('images/meena-bazar.jpg')}}" alt="store image">

        <div class="meta-detail">
          <h3 class="card-store-title">MEENA BAZAAR</h3>
        </div>
        <div class="learn-more-link">
          <a href="{{route('contact')}}#meena-bazaar" class="btn btn-submit detail-link"> Learn More </a>
        </div>
      </div>
      <div class="store-card">
        <img class="store-img" src="{{asset('images/rolla.jpg')}}" alt="store image">

        <div class="meta-detail">
          <h3 class="card-store-title">ROLLA St.</h3>
        </div>
        <div class="learn-more-link">
          <a href="{{route('contact')}}#rolla" class="btn btn-submit detail-link"> Learn More </a>
        </div>
      </div>
    </div>
    
    <div id="modal-container" class="modal-container"></div>
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
  <script src="{{asset('js/main/index.min.js')}}"></script>
  <script src="{{asset('js/main/modal.min.js')}}"></script>
@endpush
