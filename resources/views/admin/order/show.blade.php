@extends('admin.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
  <h5 class="card-header">Order<a href="{{route('sale.pdf', ['order' => $order->id, 'download' => 1])}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> Invoice </a>
  </h5>
  <div class="card-body">
    @if($order)
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>S.N.</th>
            <th>Order No.</th>
            <th>Name</th>
            <th>Email</th>           
            <th>Amount</th>
            <th>Tax</th>
            <th>Shipping</th>
            <th>Total Amount</th>
            <th>Payment Status</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>         
            <td>{{$order->id}}</td>
            <td>{{$order->order_no}}</td>
            <td>@if($order->fname)
                {{$order->fname}} {{$order->lname}} 
              @else 
                {{$order->cname}} {{$order->trn_no}}
              @endif
            </td>
            <td>{{$order->email}}</td>          
            <td>AED {{$order->payment->subtotal}}</td>
            <td>AED {{$order->payment->tax}}</td>
            <td>AED {{number_format($order->payment->shipping,2)}}</td>
            <td>AED {{number_format($order->payment->total,2)}}</td>
            <td>{{$order->payment->status}}</td>
            <td>
              @if($order->status=='new')
                <span class="badge badge-primary">{{$order->status}}</span>
              @elseif($order->status=='process')
                <span class="badge badge-warning">{{$order->status}}</span>
              @elseif($order->status=='delivered')
                <span class="badge badge-success">{{$order->status}}</span>
              @else
                <span class="badge badge-danger">{{$order->status}}</span>
              @endif
            </td>
            <td>
              <a href="{{route('orders.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
              <form method="POST" action="{{route('orders.destroy',[$order->id])}}">
                @csrf
                @method('delete')
                  <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
              </form>
            </td>                      
          </tr>
        </tbody>
      </table>
      <section class="confirmation_part section_padding">
        <div class="order_boxes">
          <div class="row">
            <div class="col-lg-6 col-lx-4">
              <div class="order-info">
                <h4 class="text-center pb-4">ORDER INFORMATION</h4>
                <table class="table">
                  <tr class="">
                    <td>Order Number</td>
                    <td> : {{$order->order_no}}</td>
                  </tr>
                  <tr>
                    <td>Order Date</td>
                    <td> : {{$order->created_at->format('D d M, Y')}} at {{$order->created_at->format('H:i:s')}} </td>
                  </tr>                    
                  <tr>
                    <td>Order Status</td>
                    <td> : {{$order->status}}</td>
                  </tr>
                  <tr>
                    <td>Total</td>
                    <td> : AED {{$order->payment->subtotal}}</td>
                  </tr>
                  @if($order->payment->shipping > 0)
                    <tr>                                        
                      <td>Shipping Charge</td>
                      <td> : AED {{$order->payment->shipping}}</td>                      
                    </tr>
                  @endif
                  @if($order->coupon)
                    <tr>                    
                      <td>Coupon</td>
                      <td> : AED {{number_format($order->coupon->value,2)}}</td>
                    </tr>
                  @endif
                  <tr>
                    <td>Total Amount</td>
                    <td> : AED {{number_format($order->payment->total,2)}}</td>
                  </tr>
                  <tr>
                    <td>Payment Method</td>
                    <td> : @if($order->payment->method=='cod') Cash on Delivery @else Online Payment @endif</td>
                  </tr>
                  <tr>
                    <td>Payment Status</td>
                    <td> : {{$order->payment->status}}</td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="col-lg-6 col-lx-4">
              <div class="city-info">
                <h4 class="text-center pb-4">SHIPPING INFORMATION</h4>
                <table class="table">               
                  <tr class="">
                      <td>Full Name</td>
                      <td> : 
                        @if($order->fname)
                          {{$order->fname}} {{$order->lname}} 
                        @else 
                          {{$order->cname}} {{$order->trn_no}}
                        @endif
                      </td>
                  </tr>
                  <tr>
                    <td>Email</td>
                    <td> : {{$order->email}}</td>
                  </tr>
                    <tr>
                      <td>Phone No.</td>
                      <td> : {{$order->shipping->phone}}</td>
                    </tr>
                    <tr>
                      <td>Address</td>
                      <td> : {{$order->shipping->address}}</td>
                    </tr>
                    @if($order->shipping->landmark)
                      <tr>
                        <td>Landmark</td>
                        <td> : {{$order->shipping->landmark}}</td>
                      </tr>
                    @endif
                    <tr>
                      <td>City</td>
                      <td> : {{$order->city->name}}</td>
                    </tr>
                    <tr>
                      <td>State</td>
                      <td> : {{$order->city->state->name}}</td>
                    </tr>
                    <tr>
                      <td>Country</td>
                      <td> : {{$order->city->state->country->name}}</td>
                    </tr>                                      
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    @endif

  </div>
</div>
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

</style>
@endpush
