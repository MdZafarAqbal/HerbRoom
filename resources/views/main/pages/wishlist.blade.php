@extends('main.layouts.master')
@section('title', 'Wishlist Products || HerbalCare')

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
  <section class="products-catalog">
    <div id="products-catalog" class="products catalog">
      @if($wishlists->isNotEmpty())
        @foreach($wishlists as $wishlist)
          @php
            $minprice = $wishlist->product->attrs()->min('price');
            $maxprice = $wishlist->product->attrs()->max('price');
          @endphp
              <div class="product-card {{$wishlist->product->id}}-card carousel-cell">
                <img class="product-image" src="{{$wishlist->product->photo}}" alt="product image">
                
                <div class="overlay">
                  <button id="product{{$wishlist->product->id}}" class="btn btn-quick-view" title="Quick View" onclick="showModal(id, {{$wishlist->product->id}})"> 
                    <i class="fa-regular fa-eye"></i>
                    <p>Quick View</p>
                  </button>
                </div>

                <div class="meta-detail">
                  <h3 class="product-title">{{$wishlist->product->name}}</h3>
                  @if($minprice==$maxprice)
                    <p class="price">AED <span class="value">{{number_format($wishlist->product->minprice,2)}}</span></p>
                  @else
                    <p class="price">AED <span class="value">{{number_format($wishlist->product->minprice,2)}}</span> - AED <span class="value">{{number_format($maxprice,2)}}</span></p>
                  @endif                  
                </div>
                <div class="prod-detail-link">
                  <a href="{{route('product.detail, $wishlist->product->slug)}}" class="btn btn-submit detail-link"> Product Details </a>
                  <form action="{{ route('wishlists.destroy', ['product_id' => $wishlist->product->id, 'reload' => 1]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="remove-btn btn" title="Remove"> Remove </button>
                  </form>
                </div>
              </div>
          @endforeach
      @else
        <p class="no-product">There is no product in the wishlist.</p>
      @endif
    </div>
    <div class="modal-container" id="modal-container"></div>
    <section id="checkout-popup" class="checkout-popup">
      <div id="location-popup" class="ch-popup" data-toggle="0" tabindex="-1">
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
@endpush