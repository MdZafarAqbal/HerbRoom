@extends('main.layouts.master')
@section ('title', 'Checkout Order || HerbalCare')

@push('styles')
  <link rel="stylesheet" href="{{asset('css/main/checkout.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/main/loader.min.css')}}">
@endpush

@section('main-content')
  <!-- Start Checkout -->
  <h1 class="title page-title">Checkout</h1>

  @php
    $countries = DB::table('countries')->where('status', 'active')->get();
    $states = DB::table('states')->where('country_id', '784')->get();
    $subtotal = Helper::cartSubtotal();
    $tax = Helper::cartTax();
    $discount = Helper::cartDiscount();
    $total = Helper::cartTotal();
    $order_success = session('order_success');
    $order_no = session('order_no');
  @endphp

  @if($total != 0 || $order_success)
    @guest
      <p class="checkout-para">Please register in order to checkout more quickly.</p>
    @endguest

    <section class="shop-checkout checkout-sec">
      <!-- Form -->
      <div class="form-container">
        <form id="order-form" class="form" method="post" action="{{ route('order') }}" novalidate>
          @csrf
          <h2>Customer Detail</h2>

          <div class="customer-details">
            <fieldset class="type-selection">
              <legend>Customer</legend>
              <div class="form-group">
                <input type="radio" name="cust_type" id="individual" value="individual" checked>
                <label for="individual">Individual</label>
              </div>
              
              <div class="form-group">
                <input type="radio" name="cust_type" id="company" value="company">
                <label for="company">Company</label>
              </div>
  
              @if ($errors->has('cust_type'))
                <div class="error">
                  @error('cust_type')
                    {{$message}}
                  @enderror
                </div>
              @endif
            </fieldset>
  
            <fieldset class="details">
              <legend>Invoice Details</legend>
              <div class="fl-bl">
                <div class="form-group" id="first-name">
                  <div class="form-input">
                    <input type="text" id="fname" name="fname" class="name" placeholder="First Name" value="@auth {{ old('fname') ?? auth()->user()->fname }} @else {{ old('fname') }} @endauth">
                    <label for="fname">First Name</label>
                  </div>
                  
                  @if ($errors->has('fname'))
                    <div class="error">
                      @error('fname')
                        {!! $message !!}
                      @enderror
                    </div>
                  @endif
                </div>

                <div class="form-group" id="last-name">
                  <div class="form-input">
                    <input type="text" id="lname" name="lname" class="name" placeholder="Last Name" value="@auth {{ old('lname') ?? auth()->user()->lname }} @else {{ old('lname') }} @endauth">
                    <label for="lname">Last Name</label>
                  </div>
                  
                  @if ($errors->has('lname'))
                    <div class="error">
                      @error('lname')
                        {!! $message !!}
                      @enderror
                    </div>
                  @endif
                </div>
  
                <div class="form-group collapse" id="company-name">
                  <div class="form-input">
                    <input type="text" id="cname" name="cname" placeholder="Company Name" value="@auth {{ old('cname') ?? auth()->user()->cname }} @else {{ old('cname') }} @endauth">
                    <label for="cname">Company Name</label>
                  </div>
                  
                  @if ($errors->has('cname'))
                    <div class="error">
                      @error('cname')
                        {{$message}}
                      @enderror
                    </div>
                  @endif
                </div>
                
                <div class="form-group collapse" id="trn">
                  <div class="form-input">
                    <input type="number" id="trn-no" name="trn_no" placeholder="TRN Number" value="@auth {{ old('trn_no') ?? auth()->user()->trn_no }} @else {{ old('trn_no') }} @endauth">
                    <label for="trn-no">TRN Number</label>
                  </div>
                    
                  @if ($errors->has('trn_no'))
                    <div class="error">
                      @error('trn_no')
                        {{$message}}
                      @enderror
                    </div>
                  @endif
                </div>
              </div>
  
              <div class="fl-bl">
                <div class="form-group">
                  <div class="form-input">
                    <input type="email" name="email" id="email" placeholder="someone@domain.com" value="{{ old('email') }}" required>
                    <label for="email">Email</label>
                  </div>
    
                  @if ($errors->has('email'))
                    <div class="error">
                      @error('email')
                        {{$message}}
                      @enderror
                    </div>
                  @endif
                </div>
    
                <div class="form-group">
                  <div class="form-input">
                    <input type="text" name="address" id="address" class="address-input" placeholder="Address" value="{{old('address')}}">
                    <label for="address">Address</label>
                  </div>
    
                  @if ($errors->has('address'))
                    <div class="error">
                      @error('address')
                        {{$message}}
                      @enderror
                    </div>
                  @endif
                </div>
              </div>
  
              <div class="fl-bl">
                <div class="form-group">
                  <div class="form-input">
                    <input type="text" name="landmark" id="landmark" placeholder="Landmark" value="{{old('landmark')}}">
                    <label for='landmark'>Nearby Landmark <sup class='optional'>(Optional)</label>
                  </div>

                  @if ($errors->has('landmark'))
                    <div class="error">
                      @error('landmark')
                        {{$message}}
                      @enderror
                    </div>
                  @endif
                </div>
                
                <div id="country-form-group" class="form-group">
                  <div class="form-input">
                    <input type="hidden" name="country" id="country" class="country-input h-s-input" value="784">
                    <input type="text" id="country-name" class="country-name selection-input" value="United Arab Emirates" readonly> 
                    <label for="country-name">Country</label>
                    <div class="dropdown-icon"><i class="fa-solid fa-angle-down"></i></div>
                    <ul id="countries" class="selection-list collapse">
                      @foreach($countries as $country)
                        <li id="country-{{$country->id}}" data-iso="{{$country->iso_code}}" data-call-code="{{$country->calling_code}}" onclick="country(this, {{$country->id}})">{{$country->name}}</li>
                      @endforeach
                    </ul>
                  </div>

                  @if ($errors->has('country'))
                    <div class="error">
                      @error('country')
                        {{$message}}
                      @enderror
                    </div>
                  @endif
                </div>
              </div>
  
              <div class="fl-bl">
                <div id="state-form-group" class="form-group">
                  <div class="form-input">
                    <input type="hidden" name="state" id="state" class="state-input h-s-input">
                    <input type="text" id="state-name" class="state-name selection-input" placeholder="State" readonly> 
                    <label for="state-name">State</label>
                    <div class="dropdown-icon"><i class="fa-solid fa-angle-down"></i></div>
                    <ul id="states" class="selection-list collapse">
                      @foreach($states as $state)
                        <li id="state-{{$state->id}}" data-state="{{$state->id}}" data-country="784" onclick="state(this)">{{$state->name}}</li>
                      @endforeach
                    </ul>
                  </div>

                  @if ($errors->has('state'))
                    <div class="error">
                      @error('state')
                        {{$message}}
                      @enderror
                    </div>
                  @endif
                </div>
  
                <div id="city-form-group" class="form-group">
                  <div class="form-input">
                    <input type="hidden" name="city" id="city" class="city-input h-s-input">
                    <input type="text" id="city-name" class="city-name selection-input" placeholder="City" readonly>
                    <label for="city-name">City</label>
                    <div class="dropdown-icon"><i class="fa-solid fa-angle-down"></i></div>
                    <ul id="cities" class="selection-list collapse"></ul>
                  </div>

                  @if ($errors->has('city'))
                    <div class="error">
                      @error('city')
                        {{$message}}
                      @enderror
                    </div>
                  @endif
                </div>
              </div>
  
              <div class="fl-bl">
                <div class="form-group">
                  <div class="phone-div">
                    <img class="flag-img flag" src="{{asset('images/flags/AE.png')}}" alt="Country Flag Image" width="40" height="20">
                    <input type="text" class="phone-code" value="+971" readonly>
                    <div class="form-input">
                      <input type="tel" name="phone" id="phone" class="phone-input" placeholder="50 123 4567" value="{{old('phone')}}">
                      <label for="phone">Phone</label>
                    </div>
                  </div>

                  @if ($errors->has('phone'))
                    <div class="error">
                      @error('phone')
                        {{$message}}
                      @enderror
                    </div>
                  @endif
                </div>
  
                <div class="form-group">
                  <div class="phone-div">
                    <img class="flag-img flag" src="{{asset('images/flags/AE.png')}}" alt="Country Flag Image" width="40" height="20">
                    <input type="text" class="phone-code" value="+971" readonly>
                    <div class="form-input">
                      <input type="tel" name="altphone" id="altphone" class="phone-input altphone-input" placeholder="50 123 4567" value="{{old('altphone')}}">
                      <label for="altphone">Phone <sup class='optional'>(Optional)</sup></label>
                    </div>
                  </div>

                  @if ($errors->has('altphone'))
                    <div class="error">
                      @error('altphone')
                        {{$message}}
                      @enderror
                    </div>
                  @endif
                </div>
              </div>
            </fieldset>
  
            <fieldset class="details">
              <legend>Shipping Details</legend>
              <h5>Same As Above?</h5>
              <div class="type-selection">
                <div class="form-group">
                  <input type="radio" name="shipping_option" id="same" value="same" checked>
                  <label for="same">Yes</label>
                </div>
                
                <div class="form-group">
                  <input type="radio" name="shipping_option" id="different" value="different">
                  <label for="different">No</label>
                </div>
              </div>
  
              <div id="shipping-details" class="collapse">
                <div class="fl-bl">
                  <div class="form-group" id="shipping-first-name">
                    <div class="form-input">
                      <input type="text" id="shipping-fname" class="name" name="shipping_fname" placeholder="First Name" value="{{old('shipping_fname')}}">
                      <label for="shipping-fname">First Name</label>
                    </div>

                    @if ($errors->has('shipping_fname'))
                      <div class="error">
                        @error('shipping_fname')
                          {{$message}}
                        @enderror
                      </div>
                    @endif
                  </div>
  
                  <div class="form-group" id="shipping-last-name">
                    <div class="form-input">
                      <input type="text" id="shipping-lname" name="shipping_lname" class="name" placeholder="Last Name" value="{{old('shipping_lname')}}">
                      <label for="shipping-lname">Last Name</label>
                    </div>

                    @if ($errors->has('shipping_lname'))
                      <div class="error">
                        @error('shipping_lname')
                          {{$message}}
                        @enderror
                      </div>
                    @endif
                  </div>
                </div>
  
                <div class="form-group">
                  <div class="form-input">
                    <input type="text" name="shipping_address" id="shipping-address" class="address" placeholder="Shipping Address" value="{{old('shipping_address')}}">
                    <label for="shipping-address">Address</label>
                  </div>
  
                  @if ($errors->has('shipping_address'))
                    <div class="error">
                      @error('shipping_address')
                        {{$message}}
                      @enderror
                    </div>
                  @endif
                </div>
  
                <div class="fl-bl">
                  <div class="form-group">
                    <div class="form-input">
                      <input type="text" name="shipping_landmark" id="shipping-landmark" placeholder="Nearby Landmark" value="{{old('shipping_landmark')}}">
                      <label for="shipping-landmark">Nearby Landmark <sup class='optional'>(Optional)</sup></label>
                    </div>

                    @if ($errors->has('shipping_landmark'))
                      <div class="error">
                        @error('shipping_landmark')
                          {{$message}}
                        @enderror
                      </div>
                    @endif
                  </div>
  
                  <div id="shipping-country-form-group" class="form-group">
                    <div class="form-input">
                      <input type="hidden" name="shipping_country" id="shipping-country" class="country-input h-s-input" value="784">
                      <input type="text" id="shipping-country-name" class="country-name selection-input" value="United Arab Emirates" readonly> 
                      <label for="shipping-country-name">Country</label>
                      <div class="dropdown-icon"><i class="fa-solid fa-angle-down"></i></div>
                      <ul id="shipping-countries" class="selection-list collapse">
                        @foreach($countries as $country)
                          <li id="shipping-country-{{$country->id}}" data-iso="{{$country->iso_code}}" data-call-code="{{$country->calling_code}}" onclick="country(this, {{$country->id}})">{{$country->name}}</li>
                        @endforeach
                      </ul>
                    </div>

                    @if ($errors->has('shipping_country'))
                      <div class="error">
                        @error('shipping_country')
                          {{$message}}
                        @enderror
                      </div>
                    @endif
                  </div>
                </div>

                <div class="fl-bl">
                  <div id="shipping-state-form-group" class="form-group">
                    <div class="form-input">
                      <input type="hidden" name="shipping_state" id="shipping-state" class="state-input  h-s-input" value="{{old('shipping_state')}}">
                      <input type="text" id="shipping-state-name" class="state-name selection-input" placeholder="State" readonly> 
                      <label for="shipping-state-name">State</label>
                      <div class="dropdown-icon"><i class="fa-solid fa-angle-down"></i></div>
                      <ul id="shipping-states" class="selection-list collapse">
                        @foreach($states as $state)
                          <li id="shipping-state-{{$state->id}}" data-state="{{$state->id}}" data-country="784" onclick="state(this)">{{$state->name}}</li>
                        @endforeach
                      </ul>
                    </div>

                    @if ($errors->has('shipping_state'))
                      <div class="error">
                        @error('shipping_state')
                          {{$message}}
                        @enderror
                      </div>
                    @endif
                  </div>
    
                  <div id="shipping-city-form-group" class="form-group">
                    <div class="form-input">
                      <input type="hidden" name="shipping_city" id="shipping-city" class="city-input  h-s-input" value="{{old('shipping_city')}}">
                      <input type="text" id="shipping-city-name" class="city-name selection-input" placeholder="City" readonly>
                      <label for="shipping-city-name">City</label>
                      <div class="dropdown-icon"><i class="fa-solid fa-angle-down"></i></div>
                      <ul id="shipping-cities" class="selection-list collapse"></ul>
                    </div>

                    @if ($errors->has('shipping_city'))
                      <div class="error">
                        @error('shipping_city')
                          {{$message}}
                        @enderror
                      </div>
                    @endif
                  </div>
                </div>
    
                <div class="fl-bl">
                  <div class="form-group">
                    <div class="phone-div">
                      <img class="shipping-flag-img flag" src="{{asset('images/flags/AE.png')}}" alt="Country Flag Image" width="40" height="20">
                      <input type="text" class="phone-code" value="+971" readonly>
                      <div class="form-input">
                        <input type="tel" name="shipping_phone" id="shipping-phone" class="phone-input" placeholder="50 123 4567" value="{{old('shipping_phone')}}">
                        <label for="shipping-phone">Phone</label>
                      </div>
                    </div>

                    @if ($errors->has('shipping_phone'))
                      <div class="error">
                        @error('shipping_phone')
                          {{$message}}
                        @enderror
                      </div>
                    @endif
                  </div>
    
                  <div class="form-group">
                    <div class="phone-div">
                      <img class="shipping-flag-img flag" src="{{asset('images/flags/AE.png')}}" alt="Country Flag Image" width="40" height="20">
                      <input type="text" class="phone-code" value="+971" readonly>
                      <div class="form-input">
                        <input type="tel" name="shipping_altphone" id="shipping-altphone" class="phone-input altphone-input" placeholder="50 123 4567" value="{{old('shipping_altphone')}}">
                        <label for="shipping-altphone">Phone <sup class='optional'>(Optional)</sup></label>
                      </div>
                    </div>

                    @if ($errors->has('shipping_altphone'))
                      <div class="error">
                        @error('shipping_altphone')
                          {{$message}}
                        @enderror
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </fieldset>
          </div>

          <h2>Payment Detail</h2>

          <div class="payment-detail">
            <fieldset class="payment-mthd type-selection">
              <legend>Payment Method</legend>
              <div class="form-group">
                <input type="radio" name="pay_mthd" id="op-input" value="op" checked>
                <label for="op-input">Online Payment</label>
              </div>
              <div class="form-group">
                <input type="radio" name="pay_mthd" id="cod-input" value="cod">
                <label for="cod-input">Cash on Delivery</label>
              </div>
            </fieldset>
  
            <fieldset class="op-form" id="op-form">
              <legend>Online Payment</legend>
              <div class="fl-bl">
                <div class="form-group">
                  <div class="form-input">
                    <input type="tel" id="account-no" class="account-no"  name="account_no"  placeholder="4242 4242 4242 4242">
                    <label for="account-no">Card Number</label>
                  </div>

                  @if ($errors->has('account_no'))
                    <div class="error">
                      @error('account_no')
                        {{$message}}
                      @enderror
                    </div>
                  @endif
                </div>
                
                <div class="form-group">
                  <div class="form-input">
                    <input type="text" id="account-name" class="account-name name" name="account_name" placeholder="Full Name (As per Card)" autocomplete="on">
                    <label for="account-name">Full Name</label>
                  </div>
                </div>

                @if ($errors->has('account_name'))
                  <div class="error">
                    @error('account_name')
                      {!! $message !!}
                    @enderror
                  </div>
                @endif
              </div>
  
              <div class="fl-bl">
                <div class='form-group expiry'>
                  <div class="form-input">
                    <input type="number" class='expiry-month' id='expiry-month' name="expiry_month" placeholder='MM'>
                    <label for="expiry-month">Expiry Month</label>
                  </div>

                  @if ($errors->has('expiry_month'))
                    <div class="error">
                      @error('expiry_month')
                        {{$message}}
                      @enderror
                    </div>
                  @endif
                </div>
                
                <div class='form-group expiry'>
                  <div class="form-input">
                    <input type="number" class='expiry-year' id='expiry-year' name="expiry_year" placeholder='YYYY'>
                    <label for="expiry-year">Expiry Year</label>
                  </div>

                  @if ($errors->has('expiry_year'))
                    <div class="error">
                      @error('expiry_year')
                        {{$message}}
                      @enderror
                    </div>
                  @endif
                </div>
  
                <div class="form-group cvc">
                  <div class="form-input">
                    <input type="password" id="cvv-cvc" class="cvv-cvc" name="cvv_cvc" placeholder="CVV/CVC" onkeypress="if(this.value.length == 3) return false;" autocomplete="off">
                    <label for="cvv-cvc">CVV/CVC</label>
                  </div>

                  @if ($errors->has('cvv_cvc'))
                    <div class="error">
                      @error('cvv_cvc')
                        {{$message}}
                      @enderror
                    </div>
                  @endif
                </div>
              </div>
  
              <div class="payment-options">
                <img src="{{('images/visa-card.png')}}" alt="Visa Card Image" width="541" height="348">
                <img src="{{('images/master-card.png')}}" alt="Master Card Image" width="541" height="348">
              </div>
            </fieldset>
          </div>
          <input type="submit" class="btn btn-checkout btn-plc" value="Place Order">
        </form>
      </div>

      <div class="order-summary">
        <div class="sums-summary">
          <div class="summary-title-container">
            <h2>Order Summary</h2>
          </div>
          <div class="coupon">
            <h3>Have Coupon?</h3>
            <input name="code" id="coupon-code" placeholder="Enter Coupon Code">
            <button id="coupon-apply" class="btn coupon-btn">Apply</button>
          </div>
          <div class="cart-totals">
            <div class="cart-total-value">
              <strong class="subtotal" data-price="{{Helper::cartSubtotal()}}"> Amount <span>(Excluding VAT)</span>: </strong>
              <span id="subtotal-value">AED {{number_format($subtotal, 2)}}</span>
            </div>
            @auth
              <div class="cart-total-value">
                <strong class="discount"> Discount Applied: </strong>
                <span id="discount-value">AED {{number_format($discount, 2)}}</span>
              </div>
            @endauth
            <div class="cart-total-value">
              <strong class="tax"> VAT Applied <span>(5%)</span>: </strong>
              <span id="tax-value">AED {{number_format($tax, 2)}}</span>
            </div>
            <div class="cart-total-value">
              <strong class="shopping"> Shipping: </strong>
              <span id="shipping-value">AED 0.00</span>
            </div>
          </div>
        
          <div class="cart-total-value grand-total">
            <strong class="total"> Total Amount: </strong>
            <span id="grand-total-value" data-total={{$total}}>AED {{number_format($total, 2)}}</span>
          </div>
          <input type="submit" form="order-form" class="btn btn-checkout btn-plc-summary" value="Place Order">
        </div>
        <div class="cart" id="cart-summary">
          @php
            $carts = Helper::cartItems();
          @endphp

          @if($carts)
          <div class="summary-title-container">
            <h2>Cart Summary</h2>
          </div>
          @foreach($carts as $cart)
          <div class="cart-item">
            <img src="{{ $cart->attr->product->photo }}" alt="product photo" class="cart-product-img zoom-img">
            <div class="cart-item-meta">
              <h3 class="cart-page-item-name">{{ $cart->attr->product->name }}</h3>
              <div class="cart-item-stats">
                @if($cart->attr->form_id)
                  <div class="flex-container">
                    <div class="cart-page-item-price flex-item">
                      <strong>Price: </strong>
                      <span>AED {{number_format($cart->attr->price, 2)}}</span>
                    </div>

                    <div class="cart-page-item-form flex-item">
                      <strong>Form: </strong>
                      <span>{{$cart->form}}</span>
                    </div>
                  </div>

                  <div class="flex-container">
                    <div class="cart-page-item-size flex-item">
                      <strong>Size: </strong>
                      <span>{{$cart->attr->size}}</span>
                    </div>

                    <div class="cart-page-item-quantity flex-item">
                      <strong>Quantity: </strong>
                      <span>{{$cart->quantity}}</span>
                    </div>
                  </div>

                  <div class="cart-page-item-total flex-item">
                    <strong>Total: </strong>
                    <span id="{{$cart->id}}-total">AED {{number_format($cart->total, 2)}}</span>
                  </div>
                @else
                  <div class="flex-container">
                    <div class="cart-page-item-price flex-item">
                      <strong>Price: </strong>
                      <span>AED {{number_format($cart->attr->price, 2)}}</span>
                    </div>

                    <div class="cart-page-item-size flex-item">
                      <strong>Size: </strong>
                      <span>{{$cart->attr->size}}</span>
                    </div>
                  </div>

                  <div class="flex-container">
                    <div class="cart-page-item-quantity flex-item">
                      <strong>Quantity: </strong>
                      <span>{{$cart->quantity}}</span>
                    </div>

                    <div class="cart-page-item-total flex-item">
                      <strong>Total: </strong>
                      <span id="{{$cart->id}}-total">AED {{number_format($cart->total, 2)}}</span>
                    </div>
                  </div>
                @endif
              </div>
            </div>
          </div>
          @endforeach

          @else
            <p>Sorry! Your cart is empty. Choose products <a href="{{route('home')}}"> here </a>!</p>
          @endif
        </div>
      </div>
    </section>

    <section class="loader-section popup-sec collapse">
      <div class="popup-container loader-container">
        <div class="loader">
          <div class="box box0">
            <div></div>
          </div>
          <div class="box box1">
            <div></div>
          </div>
          <div class="box box2">
            <div></div>
          </div>
          <div class="box box3">
            <div></div>
          </div>
          <div class="box box4">
            <div></div>
          </div>
          <div class="box box5">
            <div></div>
          </div>
          <div class="box box6">
            <div></div>
          </div>
          <div class="box box7">
            <div></div>
          </div>
          <div class="ground">
            <div></div>
          </div>
        </div>
      </div>
    </section>

    <section class="popup-sec order-success collapse">
      <div class="popup-container">
        <h3>Your order has been placed!</h3>
        <i class="fa-solid fa-circle-check fa-beat fa-xl success-icon"></i>
        <p>Thankyou for your purchase!</p>
        <p>Your order number is: <span id="order-no"></span></p>
        <p>You have received an order confirmation email with details of your order.</p>
        <a href="{{route('home')}}" class="btn btn-submit"> Continue Shopping </a>
      </div>
    </section>

  @else
    <h4>Please add items to cart to proceed further. <a href="{{route('home')}}">Continue Shopping</a></h4>
  @endif
@endsection

@push('scripts')
<script src="{{asset('js/main/checkout.min.js')}}"></script>

@if($order_success)
  <script>
    $(document).ready(function() {
      $('body').css('height', '90vh');
      $('body').css('overflow', 'hidden');
      $('.order-success').removeClass('collapse');
      $('#order-no').html('<?= $order_no ?>');
    });
  </script>
@endif
@endpush