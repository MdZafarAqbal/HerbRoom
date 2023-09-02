@extends('main.layouts.master')
@section('title') 
  {{$product->name}} - Product Detail || HerbalCare 
@endsection

@push('vendor_styles')
  <link rel="stylesheet" href="{{asset('css/vendor/exzoom.min.css')}}">
@endpush

@push('styles')
  <link href="{{asset('css/main/product-detail.min.css')}}" rel="stylesheet">
@endpush

@push('vendor_scripts')
  <script src="{{asset('js/vendor/exzoom.min.js')}}" async></script>
@endpush

@section('main-content')
  <section id="product-detail" class="modal-content">	
    <div class="exzoom collapse" id="exzoom">
      @if(count($product->images) != 0)
        <div class="exzoom-img-box">
          <ul class="exzoom-img-ul">
            @foreach($product->images as $image)
              <li><img src="{{('/images/products'.$image->name)}}"/></li>	
            @endforeach										
          </ul>
        </div>
        <div class="exzoom-nav"></div>
        <!-- Nav Buttons -->
        <p class="exzoom-btn">
          <a href="javascript:void(0);" class="exzoom-prev-btn"> < </a>
          <a href="javascript:void(0);" class="exzoom-next-btn"> > </a>
        </p>
      @endif
    </div>
		<div class="modal-details-container">
      <div class="product-modal-detail">
        <h1 class="title">{{$product->name}}</h1>
        @if($product->sci_name)
          <div class="subtitle-div">
            <h4 class="subtitle">Scientific Name: </h4><span class="normal">{{$product->sci_name}}</span>
          </div>
        @endif
        
				@php
          $rating = ceil($product->reviews->where('status', 'active')->avg('rating'));
				@endphp
        
				@for($i = 1; $i <= 5; $i++)
          @if($rating >= $i)
            <i class="fa-solid fa-star"></i>
					@else 
            <i class="fa-regular fa-star"></i>
					@endif
        @endfor
          
        <a href="#reviews" class="total-review">({{$product->reviews->where('status', 'active')->count()}}) Review</a>
          
        <div id="modal-form">
          @php
            $forms = $product->forms()->get();
            $images = $product->images()->pluck('name');
            $sizes = array();

            if($forms->isEmpty()) {
              $minprice = $product->attrs()->min('price');
              $maxprice = $product->attrs()->max('price');
              $sizes = $product->attrs()->select('unit', 'size')->get();
            } else {
              $minprice = $product->attrs()->where('form_id', $forms[0]->id)->min('price');
              $maxprice = $product->attrs()->where('form_id', $forms[0]->id)->max('price');
              $sizes = $product->attrs()->where('form_id', $forms[0]->id)->select('unit', 'size')->get();
            }

            $minprice = number_format($minprice, 2);
            $maxprice = number_format($maxprice, 2);
          @endphp

          @if($forms->isNotEmpty())
            <div class="forms modal-radio" id="forms">
              <div id="forms-menu" class="forms-list">
                @foreach($forms as $form)
                  @if($form == $forms[0])
                    <input type="radio" id="{{$form->name}}" name="product-form" value="{{$form->id}}" checked>
                    <label for="{{$form->name}}">{{$form->name}}</label>
                  @else
                    <input type="radio" id="{{$form->name}}" name="product-form" value="{{$form->id}}">
                    <label for="{{$form->name}}">{{$form->name}}</label>
                  @endif
                @endforeach
              </div>
            </div>
          @endif
          <div class="price-size-container modal-radio" id="price-size">
            <div class="prices" id="price">
              @if($minprice == $maxprice)
                <strong>AED {{$minprice}}</strong>
              @else
                <strong>AED {{$minprice}} - AED {{$maxprice}}</strong>
              @endif            
            </div>
            <div id="sizes-menu" class="sizes-list">
              @foreach($sizes as $size)
                <input type="radio" id="{{$size->size}}" name="product-size" class="product-size" value="{{$size->size}}">
                <label for="{{$size->size}}">{{$size->size}} {{$size->unit}}</label>
              @endforeach
            </div>
          </div>
          <input type="hidden" name="price-input" id="price-input" value="">
          <div class="qty-manage" id="qty-manage">
            <input type="button" value="-" class="qty-minus minus qty-control" field="quantity" disabled>
            <input type="number" name="quantity" id="qty" class="qty" value="1" min="1" oninput="this.value = Math.abs(this.value)" disabled>
            <input type="button" value="+" class="qty-plus plus qty-control" field="quantity" disabled>
          </div>
          <div class="cart-btn-div" onclick="cartAdd({{$product->id}})">
            <button form="modal-cart-form" id="detail-cart-btn" class="cart-btn">
              <span class="add-to-cart">Add to Cart</span>
              <span class="added">Added</span>
              <i class="fas fa-shopping-cart"></i>
              <i class="fas fa-box"></i>
            </button>
          </div>
        </div>
      </div>
		</div>
	</section>

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
  
	<section class="details reviews"> 
		{{-- @php
			$benefits = explode('@', $product->benefits);
			$descriptions = explode('$', $product->description);
			$precautions = explode('@', $product->precautions);
			$packagings = explode('@', $product->packaging_details);
		@endphp --}}
		
		<div class="details-review-div">
			<button id="details-btn" class="btn details-review-btn active-details-review" data-toggle="description" onclick="showDetail(this)">Details</button>
			<button id="reviews-btn" class="btn details-review-btn" data-toggle="reviews" onclick="showDetail(this)">Reviews</button>
		</div>
		
		<div class="tab-content" id="tab-content">
			<!-- Description Tab -->
			<div class="tab-panel" id="description">
				{{-- @if ($benefits[0])
					<h3> Benefits: </h3>
					<ul class="benefits">
						@foreach ($benefits as $benefit)
							<li>{{$benefit}}</li>
						@endforeach
					</ul>
				@endif --}}
				@if ($product->description)
					{!! $product->description !!}
				@endif
        {{-- @if ($precautions[0])
          <h3> Precautions: </h3>
          <ul class="precautions">
            @foreach($precautions as $precaution)
              <li>{{$precaution}}</li>
            @endforeach
          </ul>
        @endif
        @if ($packagings[0])
          <h3> Packaging Details: </h3>
          <ul class="precautions">
            @foreach($packagings as $packaging)
              <li>{{$packaging}}</li>
            @endforeach
          </ul>
        @endif
        <h3> Disclaimer: </h3>
        <ul class="precautions">
          <li>The images shown are for illustration purposes only and may not be an exact representation of the product.</li>
          <li>For education purposes only.</li>
        </ul> --}}
			</div>
			<!-- End Description Tab -->

			<!-- Reviews Tab -->
			<div class="tab-panel collapse" id="reviews">
				<div class="add-review">
					<h3>Add Review</h3>
					<p>Your email address will not be published.</p>
				</div>
        
				<div class="review-inner">
					<h4>Your Rating</h4>

					@auth 
						<form class="form" method="post" action="{{route('review.store', $product->slug)}}"> 
							@csrf 
							<div class="rate">
								<input type="radio" id="star5" name="rate" value="5" />
								<label for="star5" title="text">5 stars</label>
								<input type="radio" id="star4" name="rate" value="4" />
								<label for="star4" title="text">4 stars</label>
								<input type="radio" id="star3" name="rate" value="3" />
								<label for="star3" title="text">3 stars</label>
								<input type="radio" id="star2" name="rate" value="2" />
								<label for="star2" title="text">2 stars</label>
								<input type="radio" id="star1" name="rate" value="1" />
								<label for="star1" title="text">1 star</label>
							</div>

							<div class="form-group">
								<textarea name="review" placeholder="Write a review"  rows="6" cols="50"></textarea>
							</div>

							<div class="form-review-btn">
								<button type="submit" class="btn ">Submit</button>
							</div>
						</form> 
					@else 
						<p class="review-auth-action"> 
							You need to <a href="{{route('login.view')}}" class="review-auth-link form-review-btn btn">Login</a> OR <a href="{{route('register.view')}}" class="review-auth-link form-review-btn btn">Register</a>
						</p>
					@endauth
				</div>

				<div class="user-reviews">
					<div class="prev-reviews">
						<h3>Reviews</h3>
					</div>
					@foreach($product->reviews as $data)
						<div class="single-rating">
							<div class="rating-author"> 
								
								<h4>{{$data->user['fname']}}</h4>
							</div>

							<div class="rating-des">
								<div class="ratings">
									<ul class="rating"> 
										@for($i=1; $i<=5; $i++) 
											@if($data->rating>=$i) 
												<li> <i class="fa-solid fa-star"></i> </li> 
											@else 
												<li> <i class="fa-regular fa-star"></i> </li> 
											@endif 
										@endfor 
									</ul>
									<span class="rate-count"> ( {{$data->rating}} ) </span>
								</div>
								<p>{{$data->review}}</p>
							</div>
						</div> 
					@endforeach
				</div>
			</div>
			<!--/ End Review -->
		</div>
	</section>
  
  @if($relproducts->isNotEmpty())
    <!-- Start Related Products -->
    <section class="products-area related-products">
      <div class="section-title">
        <h2>Related Products</h2>
      </div>

      <div class="products">
        <div class="product-slider carousel hero-slider"  data-flickity='{ "autoPlay": 3000, "contain": true, "pageDots": false, "initialIndex": 2 }'>
          @foreach($relproducts as $relproduct)
            @continue($relproduct->id == $product->id)
              
            @php
              $min_price = $relproduct->attrs->min('price');
              $max_price = $relproduct->attrs->max('price');
              if(Auth::check())
                $wishlist = $relproduct->wishlists()->where('user_id', Auth()->user()->id)->get();
            @endphp

            <div class="product-card {{$relproduct->id}}-card carousel-cell">
              <a href="{{route('product.detail', $relproduct->slug)}}">
                <img class="product-image" src="{{$relproduct->photo}}" alt="product image">
              </a>

              <div class="meta-detail">
                <h3 class="product-title">{{$relproduct->name}}</h3>
                @if($minprice==$maxprice)
                  <p class="price">AED <span class="value">{{number_format($min_price, 2)}}</span></p>
                @else
                  <p class="price">AED <span class="value">{{number_format($min_price, 2)}}</span> - AED <span class="value">{{number_format($max_price, 2)}}</span></p>
                @endif							
              </div>
              <div class="prod-detail-link">
                <a href="{{route('product.detail', $relproduct->slug)}}" class="btn btn-submit detail-link"> Product Details </a>
                @auth
                  @if(count($wishlist) != 0)
                    <button class="btn favbtn" onclick="fav(this, {{$relproduct->id}})"><i class="fa-solid fa-heart fav"></i></button>
                  @else
                    <button class="btn favbtn" onclick="fav(this, {{$relproduct->id}})"><i class="fa-regular fa-heart fav"></i></button>
                  @endif
                @else
                  <button class="btn favbtn" onclick="window.location.href = '/login';"><i class="fa-regular fa-heart fav"></i></button>
                @endauth
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
    <!-- End Related Products -->
  @endif
@endsection

@push('scripts')
	<script src="{{asset('js/main/product-detail.min.js')}}"></script>
	<script>
    /* Actions when size is not checked */
    if($('[name="product-size"]:checked').val() == undefined) {
      $('.cart-btn-div').css('width', 0);
      $('.plus').attr('disabled', true);
      $('input.qty').attr('disabled', true);
    }

		price(<?= $product->id ?>);

		window.onload = function() {
  		$(function() {
        $('.modal-content').imagesLoaded(function () {
          $('#exzoom').exzoom({
            autoPlay: false,
          });
          $('#exzoom').removeClass('collapse')
        });

				/* Actions when form is changed */
				$('[name="product-form"]').on('change', function() {
					let formId = $('[name="product-form"]:checked').val();

          createSizes(<?= $product->id ?>, formId);

          $('.cart-btn-div').css('width', 0);
          $('input.qty').val('1');
          $('.plus').attr('disabled', true);
          $('input.qty').attr('disabled', true)
          $('.minus').attr('disabled', true);
					price(<?= $product->id ?>);
				})

				/* Enable minus button when value of input quantity is greater than 1 and vice versa */
				$('input.qty').on('change', function() {
					if ($('input.qty').val() > 1)
						$('.minus').removeAttr('disabled');
					else
						$('.minus').attr('disabled', true);
				})
			})
		}
	</script>
@endpush