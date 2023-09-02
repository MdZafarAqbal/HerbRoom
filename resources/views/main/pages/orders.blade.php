@extends('main.layouts.master')
@section('title', 'Order Details || HerbalCare')

@push('styles')
  <link rel="stylesheet" href="{{asset('css/main/orders.min.css')}}">
@endpush

@section('main-content')
  @php 
    $i = 0;
  @endphp
  @if ($orders)
    <h1 class="page-title">Orders</h1>
    <section class="orders-sec">
      <div class="orders-table">
        <table>
          <thead>
            <tr>
              <th>S.No</th>
              <th>Order No</th>
              <th>Name</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Details</th>
            </tr>
          </thead>
          
          @foreach ($orders as $order)
            @php 
              $i++;
            @endphp
            <tr>
              <td>{{$i}}</td>
              <td>{{$order->order_no}}</td>
              <td>{{$order->fname}} {{$order->lname}}</td>
              <td>AED {{$order->payment->total}}</td>
              <td>{{ucfirst($order->status)}}</td>
              <td>
                <a href="{{route('order-detail', ['order_no' => $order->order_no])}}" class="btn btn-submit order-detail-btn">Order Detail</a>
              </td>
            </tr>
          @endforeach
        </table>
      </div>
    </section>
  @endif

  <section class="order-detail-sec">
    <div class="img-container">
      <img src="{{asset('images/order-detail.png')}}" class="order-detail-img" id="order-detail-img">
    </div>
    <div class="order-detail-container">
      <h2>Order Detail</h2>
      <p>Enter the order number in the input box below and check details of the order. Order number would be given at the invoice slip.</p>
      <div class="form-group">
        <label for="order-id-input">Order No:</label>
        <input type="text" class="order-input" id="order-input" name="order_no" placeholder="Enter order number">
      </div>

      <div class="form-group submit-detail">
        <button id="order-detail-btn" class="btn btn-submit order-detail-btn">Order Detail</button>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script src="{{asset('js/main/orders.min.js')}}"></script>
@endpush