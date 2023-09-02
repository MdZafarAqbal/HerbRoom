@extends('main.layouts.master')
@section('title', 'Order Detail || HerbalCare')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/main/order-detail.css') }}">
@endpush

@section('main-content')
  @if ($order)
    <section class="order-detail-sec" id="order-detail-sec">
      <h1 class="page-title">Order Detail</h1>
      <div class="order-detail-container">
        <div class="order">
          <h2>ORDER: </h2>
          <h3 id="order-no">#{{ $order->order_no }}</h3>
        </div>

        <div class="status-container">
          <div class="status">
            <h4>Payment Status: </h4>
            <div class="status-value">{{ ucfirst($order->payment->status) }}</div>
          </div>
          <div class="status">
            <h4>Order Status: </h4>
            <div class="status-value">{{ ucfirst($order->status) }}</div>
          </div>
          <div class="status">
            <h4>Shipping Status: </h4>
            <div class="status-value">{{ ucfirst($order->shipping->status) }}</div>
          </div>
        </div>

        <h3 class="summary-title">Summary</h3>
        <div class="summary-container">
          <div class="payment-summary summary">
            <div class="summary-detail">
              <h5>Subtotal: </h5>
              <div class="payment-value">AED {{number_format($order->payment->subtotal, 2)}}</div>
            </div>
            <div class="summary-detail">
              <h5>VAT (5%): </h5>
              <div class="payment-value">AED {{number_format($order->payment->tax, 2)}}</div>
            </div>
            <div class="summary-detail">
              <h5>Discount: </h5>
              <div class="payment-value">AED {{number_format($order->payment->discount, 2)}}</div>
            </div>
            <div class="summary-detail">
              <h5>Shipping: </h5>
              <div class="payment-value">AED {{number_format($order->payment->shipping, 2)}}</div>
            </div>
            <hr>
            <div class="summary-detail">
              <h5>Total: </h5>
              <div class="payment-value">AED {{number_format($order->payment->total, 2)}}</div>
            </div>
          </div>
        </div>
          
        <div class="address-container">
          <div class="billing-address">
            <h3 class="address-type">Billing Address</h3>
            <div class="billing-address address">
              @php 
                $city = App\Models\City::with('state', 'country')->where('id', $order->city_id)->first();
              @endphp
              @if($order->cname == null)
                <div class="address-detail">
                  <h5>Name: </h5><div class="address-value">{{$order->fname}} {{$order->lname}}</div>
                </div>
              @else
                <div class="address-detail">
                  <h5>Company: </h5><div class="address-value">{{$order->cname}}</div>
                </div>
  
                <div class="address-detail">
                  <h5>TRN No: </h5><div class="address-value">{{$order->trn_no}}</div>
                </div>
                @endif
                <div class="address-detail">
                  <h5>Phone: </h5><div class="address-value">+ {{$city->country->calling_code}} {{$order->phone}}</div>
                </div>
                <div class="address-detail">
                  <h5>Email: </h5><div class="address-value email-address">{{$order->email}}</div>
                </div>
                <div class="address-detail">
                  <h5>Address: </h5><div class="address-value st-address">{{$order->address}}, {{$city->name}}, {{$city->state->name}}, {{$city->country->name}}</div>
                </div>
            </div>
          </div>
            
          <div class="shipping-address">
            <h3 class="address-type">Shipping Address</h3>
            <div class="shipping-address address">
              @php 
                $shipping_city = App\Models\City::with('state', 'country')->where('id', $order->shipping->city_id)->get()[0];
              @endphp
              @if($order->cname == null)
                <div class="address-detail">
                  <h5>Name: </h5><div class="address-value">{{$order->shipping->fname}} {{$order->shipping->lname}}</div>
                </div>
              @else
                <div class="address-detail">
                  <h5>Company: </h5><div class="address-value">{{$order->shipping->cname}}</div>
                </div>
                <div class="address-detail">
                  <h5>TRN No: </h5><div class="address-value">{{$order->shipping->trn_no}}</div>
                </div>
              @endif
              <div class="address-detail">
                <h5>Phone: </h5><div class="address-value">+ {{$shipping_city->country->calling_code}} {{$order->shipping->phone}}</div>
              </div>
              <div class="address-detail">
                <h5>Address: </h5><div class="address-value st-address">{{$order->shipping->address}}, {{$shipping_city->name}}, {{$shipping_city->state->name}}, {{$shipping_city->country->name}}</div>
              </div>
            </div>
          </div>
        </div>

        <div id="order-action" class="action">
          <a href="{{route('order-track', ['order_no' => $order->order_no])}}" class="btn btn-submit action-btn">Track Order</a>
          <a href="{{route('sale.pdf', ['id' => $order->id, 'download' => 1])}}" class="btn btn-submit action-btn">Sale Order</a>
          
          @if ($order->status == 'completed')
            <a href="{{route('tax.pdf', ['id' => $order->id, 'download' => 1])}}" class="btn btn-submit action-btn">Tax Invoice</a>
          @endif

          @if($cancel && $order->status != 'cancelled')
            <a href="{{route('cancel-view', ['order_no' => $order->order_no, 'cancel' => true])}}" class="btn btn-submit action-btn">Remove Items</a>
          @elseif($return && $order->status != 'returned')
            <a href="{{route('return-view', ['order_no' => $order->order_no, 'return' => true])}}" class="btn btn-submit action-btn">Return Items</a>
          @endif
        </div>
      </div>
    </section>
  @else
    <div class="fail-container" id="fail">
      <p id="fail-status">Sorry there is no order with this order number. Please recheck your order number.</p>
    </div>
  @endif
@endsection
