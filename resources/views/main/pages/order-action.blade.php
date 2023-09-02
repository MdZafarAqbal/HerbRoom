@extends('main.layouts.master')
@section('title', 'Order Actions || HerbalCare')

@push('styles')
  <link rel="stylesheet" href="{{asset('css/main/order-action.min.css')}}">
@endpush

@section('main-content')
  @if ($order)
    <div class="order-details orders" id="order-details">
      <h1>Items List</h1>
      <div class="success-container" id="success">
        <div class="order-items orders-table">
          @php 
            $items = $order->order_items;
            $j = 0;
          @endphp
          @if (count($items) !== 0)
            <table>
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Image</th>
                  <th>Product</th>
                  <th>Form</th>
                  <th>Size</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Discount</th>
                  <th>Amount</th>
                  <th><input type="checkbox" name="all" id="all-checkbox" class="btn btn-submit all-checkbox" value="{{$order->id}}"></th>
                </tr>
              </thead>

              @foreach ($items as $item)
                @php 
                  $j++;
                @endphp
                <tr>
                  <td>{{$j}}</td>
                  <td><img src="{{$item->product->photo}}" alt="Product Image" width="80" height="80"></td>
                  <td>{{$item->product->name}}</td>
                  <td>{{$item->form}}</td>
                  <td>{{$item->size}}</td>
                  <td>{{number_format($item->price, 2)}}</td>
                  <td>{{$item->quantity}}</td>
                  <td>{{number_format($item->discount, 2)}}</td>
                  <td>{{number_format($item->total, 2)}}</td>
                  <td><input type="checkbox" name="item_checkbox" class="btn btn-submit item-checkbox" data-total="{{$item->total}}" value="{{$item->id}}"></td>
                </tr>
              @endforeach
            </table>
          @endif
        </div>
        <div class="summary-container">
          <div id="order-action" class="action">
            <input type="hidden" id="order" name="order" data-order="{{$order->order_no}}" value="{{$order->id}}">
            <input type="hidden" id="total" name="total" value="{{$order->payment->subtotal}}">
            <input type="hidden" id="tax" name="tax" value="{{$order->payment->tax}}">
            <input type="hidden" id="discount" name="discount" value="{{$order->payment->discount}}">
            @if($cancel)
              <button id="action" class="btn btn-submit item-cancel action-btn" disabled>Remove Selected Item</button>
            @elseif($return)
              <button id="action" class="btn btn-submit item-return action-btn" disabled>Return Selected Item</button>
            @endif
            <a href="{{ URL::previous() }}" class="btn btn-submit home-btn action-btn">Back</a>
          </div>
          <div class="summary">
            <h5>Subtotal: </h5><span class="value">AED {{number_format($order->payment->subtotal, 2)}}</span><br/>
            <h5>VAT Amount: </h5><span class="value">AED {{number_format($order->payment->tax, 2)}}</span><br/>
            <h5>Discount: </h5><span class="value">AED {{number_format($order->payment->discount, 2)}}</span><br/>
            <h5>Shipping: </h5><span class="value">AED {{number_format($order->payment->shipping, 2)}}</span><br/>
            <hr/>
            <h4>Grand Total: </h4><span class="value">AED {{number_format($order->payment->total, 2)}}</span><br/>
          </div>
        </div>
      </div>
    </div>
  @else
    <div class="fail-container" id="fail">
      <p id="fail-status">Sorry there is no order with this order number. Please recheck your order number.</p>
    </div>
  @endif

  <section id="reason-popup" class="popup">
    <div id="reason-div" class="popup-div">
      <h2>Reason</h2>
      <button type="button" class="btn close" id="close-btn" onclick="removePopup()">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <input type="hidden" name="reason" id="reason" value="">
      <ul class="reasons-list">
        <li id="mind-change" class="reason-item">Change of Mind</li>
        <li id="damaged-defective" class="reason-item">Damaged or Defective Product</li>
        <li id="no-need" class="reason-item">No Longer Needed</li>
        <li id="wrong-product" class="reason-item">Shipped Wrong Product</li>
        <li id="other" class="reason-item other-reason">Other</li>
      </ul>

      <textarea name="reason-text" id="other-text" class="collapse" cols="30" rows="10"></textarea>
      <div class="action-btns">
        <button class="btn btn-submit pop-btn" onclick="removePopup()">Back</button>
        @if($cancel)
          <button class="btn btn-submit pop-btn continue-action cancel" disabled>Continue</button>
        @else if($return)
          <button class="btn btn-submit pop-btn continue-action return" disabled>Continue</button>
        @endif
      </div>
    </div>
  </section>

  <section id="warning-popup" class="popup">
    <div id="warning-div" class="popup-div">
      <h2>Warning</h2>
      <button type="button" class="btn close" id="close-btn" onclick="removePopup()">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <p>Your order value will breach the minimum free shipping limit (i.e AED 100.00) therefore shipping charges would be added to total charges.</p>

      <div class="action-btns">
        <button class="btn btn-submit pop-btn" onclick="removePopup()">Back</button>
        <button id="continue" class="btn btn-submit pop-btn">Continue</button>
      </div>
    </div>
  </section>

  <section id="otp-popup" class="popup">
    <div id="otp-div" class="popup-div">
      <button type="button" class="btn close" id="close-btn" onclick="removePopup()">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <h2>Enter OTP Code</h2>
      <p>Please enter OTP Code sent to</p>
      <p class="mail-para">{{$order->email}}</p>

      <div class="otp-form">
        <input class="otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(1)' maxlength=1 >
        <input class="otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(2)' maxlength=1 >
        <input class="otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(3)' maxlength=1 >
        <input class="otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(4)' maxlength=1 >
        <input class="otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(5)' maxlength=1 >
        <input class="otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(6)' maxlength=1 >
      </div>
      
      @if($cancel)
        <button id="verify" class="btn btn-submit pop-btn cancel">Submit</button>
      @else if($return)
        <button id="verify" class="btn btn-submit pop-btn return">Submit</button>
      @endif

      @if($cancel)
        <div class="action-btns">
          <a class="pop-btn" onclick="resendOtp('cancel')">Resend OTP Code</a>
        </div>
      @else if($return)
        <div class="action-btns">
          <a class="pop-btn" onclick="resendOtp('return')">Resend OTP Code</a>
        </div>
      @endif
    </div>
  </section>
@endsection
  
@push('scripts')
  <script src="{{asset('js/main/order-action.min.js')}}"></script>
@endpush