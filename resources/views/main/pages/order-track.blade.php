@extends('main.layouts.master')
@section('title', 'Track Order || HerbalCare')

@push('styles')
  <link rel="stylesheet" href="{{asset('css/main/order-track.css')}}">
@endpush

@section('main-content')
<section>
  <div class="tracking-order-section">
    <div class="img-container">
      <img src="{{asset('images/trackorder.png')}}" class="tracking-order-main-img" id="tracking-order-main-img">
    </div>

    <div class="tracking-details" id="track-order-details">
      <h1>Tracking Information</h1>
      <div class="success-container" id="success">
        <div class="order-detail">
          <div class="order">
            <h2>ORDER: </h2>
            <h3 id="order-no">{{$order->order_no}}</h3>
          </div>
          <div class="status">
            <h4>Shipping Status: </h4>
            <h4 id="status">{{ucfirst($order->shipping->status)}}</h4>
          </div>
          <p id="status-line"></p>
        </div>
        <div class="tracking-dates">
          <div class="date-container">
            <div class="label">
              <div class="tracking-icon"><i class="bx bxs-shopping-bags" id="order-icon"></i></div>
              <h4>ORDERED</h4>
            </div>
            <p id="order-date" class="date">-- ------- ----</p>
          </div>
          <div class="date-container">
            <div class="label">
              <div class="tracking-icon"><i class="fa-solid fa-clipboard-list" id="process-icon"></i></div>
              <h4>PROCESSED</h4>
            </div>
            <p id="process-date" class="date">-- ------- ----</p>
          </div>
          <div class="date-container">
            <div class="label">
              <div class="tracking-icon"><i class="fa-solid fa-truck-fast" id="ship-icon"></i></div>
              <h4>SHIPPED</h4>
            </div>
            <p id="ship-date" class="date">-- ------- ----</p>
          </div>
          <div class="date-container">
            <div class="label">
              <div class="tracking-icon"><i class="bx bxs-package" id="deliver-icon"></i></div>
              <h4>DELIVERED</h4>
            </div>
            <p id="deliver-date" class="date">-- ------- ----</p>
          </div>
        </div>
        <div class="status-img-container">
          <img src="{{asset('images/ordered_track.png')}}" alt="tracking-status" id="status-img" width="50%">
        </div>
      </div>
      <div class="fail-container collapse" id="fail">
        <p id="fail-status">Sorry there is no order with this order number. Please recheck your order number and track again.</p>
      </div>
    </div>
  </div>
  
  <div class="img-container">
    <img src="{{asset('images/deliveryprocess.png')}}" class="tracking-order-main-img" id="tracking-order-main-img">
  </div>
</section>
@endsection

@push('scripts')
  <script src="{{asset('js/main/order-track.js')}}"></script>
  <script>
    $(function() {
      trackOrder(<?= $order ?>);
    });
  </script>
@endpush