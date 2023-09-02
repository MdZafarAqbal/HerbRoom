@extends('admin.layouts.master')

@section('title','Order Detail')

@section('main-content')
<form action="{{route('orders.update',$order->id)}}" method="POST">
  <div class="card">
    <h5 class="card-header">Order Status</h5>
    <div class="card-body">
      @csrf
      @method('PATCH')
      <div class="form-group">
        <label for="order_status">Order Status :</label>
        <select name="order_status" id="" class="form-control">
          <option value="new" {{($order->status=='completed' || $order->status=="processed" || $order->status=="cancelled") ? 'hidden' : ''}}  {{(($order->status=='new')? 'selected' : '')}}>New</option>
          <option value="processed" {{($order->status=='completed'|| $order->status=="cancelled") ? 'hidden' : ''}}  {{(($order->status=='processed')? 'selected' : '')}}>Processed</option>
          <option value="completed" {{($order->status=="cancelled") ? 'hidden' : ''}}  {{(($order->status=='completed')? 'selected' : '')}}>Completed</option>
          <option value="cancelled" {{($order->status=='completed') ? 'hidden' : ''}}  {{(($order->status=='cancelled')? 'selected' : '')}}>Cancelled</option>
        </select>
      </div>
    </div>
  </div>

  <div class="card">
    <h5 class="card-header">Shipping Status</h5>
  <div class="card-body">
    <div class="form-group">
      <label for="shipping_status">Shipping Status :</label>
      <select name="shipping_status" id="" class="form-control">
        <option value="ordered" {{($order->shipping->status=="processed" || $order->shipping->status=="shipped" || $order->shipping->status=="delivered") ? 'hidden' : ''}}  {{(($order->shipping->status=='ordered')? 'selected' : '')}}>Ordered</option>
        <option value="processed" {{($order->shipping->status=="shipped" || $order->shipping->status=="delivered") ? 'hidden' : ''}}  {{(($order->shipping->status=='processed') ? 'selected' : '')}}>Processed</option>
        <option value="shipped" {{($order->shipping->status=="delivered") ? 'hidden' : ''}}  {{(($order->shipping->status=='shipped') ? 'selected' : '')}}>Shipped</option>
        <option value="delivered" {{($order->shipping->status=="new") ? 'hidden' : ''}}  {{(($order->shipping->status=='delivered') ? 'selected' : '')}}>Delivered</option>
      </select>
    </div>
  </div>
  <div class="card">
    <h5 class="card-header">Payment Status</h5>
    <div class="card-body">
      <div class="form-group">
        <label for="payment_status">Payment Status :</label>
        <select name="payment_status" id="" class="form-control">
          <option value="unpaid" {{($order->payment->status=="paid") ? 'hidden' : ''}}  {{(($order->payment->status=='unpaid')? 'selected' : '')}}>Unpaid</option>
          <option value="paid" {{($order->payment->status=='unpaid') ? 'active' : ''}}  {{(($order->payment->status=='paid')? 'selected' : '')}}>Paid</option>
        </select>
      </div>      
    </div>
    <button type="submit" class="btn btn-primary" >Update</button> 
  </div>  
</form>

@if($order->payment->refund)

<form id="refund" method="post" action="{{route('payment-refund', ['id' => $order->id])}}">
  <div class="card">
    <h5 class="card-header">Payment Refund</h5>
    <div class="card-body">
      <div class="form-group">
        @csrf
        <label for="refund" class="col-form-label">Refund </label>
        <input id="refund" type="number" name="refund" value="{{$order->payment->refund}}">
        @error('refund')
          <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
    </div>
    <button type="submit" class="btn btn-primary" >Refund</button> 
  </div>
</form>

@endif  
@endsection

@push('styles')
<style>
    .order-info,.city-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.city-info h4{
        text-decoration: underline;
    }
    .btn{
      width:6em;
      display: flex;
 
    }

</style>
@endpush
