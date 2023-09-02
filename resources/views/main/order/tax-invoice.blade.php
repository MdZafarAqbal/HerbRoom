<!DOCTYPE html>
<html>
  <head>
    <title>Order - Tax Invoice</title>

    <link rel="stylesheet" href="{{public_path('css/main/pdf.css')}}">
  </head>

  <body>
    <div class="invoice-header">
      <img src="{{public_path('images/tax-invoice-header.png')}}"/>
    </div>

    <div class="watermark">HerbalCare.ae</div>

    <div class="invoice-details">
      <h4>Invoice No: {{$order->id}}</h4><br/>
      <h5>Invoice Date: </h5><span class="value">{{ date_format($order->created_at, 'M d, Y') }}</span><br/>
      <h5>Order No: </h5><span class="value">{{$order->order_no}}</span><br/>
      <h5>Order Status: </h5><span class="value">{{ucfirst($order->status)}}</span><br/>
      <h5>Payment Method: </h5><span class="value">{{strtoupper($order->payment->method)}}</span><br/>
      <h5>Payment Status: </h5><span class="value">{{ucfirst($order->payment->status)}}</span><br/>
    </div>

    <div class="address">
      <div class="billing">
        @php 
          $city = App\Models\City::with('state', 'country')->where('id', $order->city_id)->first();
        @endphp
        <h3>Billing Address</h3>
        @if($order->cname == null)
          <h5>Name: </h5><span class="value">&nbsp;&nbsp;&nbsp;&nbsp;{{$order->fname}} {{$order->lname}}</span><br/>
        @else
          <h5>Company: </h5><span class="value">&nbsp;&nbsp;&nbsp;&nbsp;{{$order->cname}}</span><br/>
          <h5>TRN No: </h5><span class="value">&nbsp;&nbsp;&nbsp;&nbsp;{{$order->trn_no}}</span><br/>
        @endif
          <h5>Phone: </h5><span class="value">&nbsp;&nbsp;&nbsp;&nbsp;+ {{$city->country->calling_code}} {{$order->phone}}</span><br/>
          <h5>Email: </h5><span class="value">&nbsp;&nbsp;&nbsp;&nbsp;{{$order->email}}</span><br/>
          <h5>Address: </h5><span class="value">&nbsp;&nbsp;&nbsp;&nbsp;{{$order->address}}, {{$city->name}},<br>{{$city->state->name}}, {{$city->country->name}}</span><br/>
      </div>
      <div class="shipping">
        @php 
          $shipping_city = App\Models\City::with('state', 'country')->where('id', $order->shipping->city_id)->get()[0];
        @endphp
        <h3>Shipping Address</h3>
        @if($order->cname == null)
          <h5>Name: </h5><span class="value">&nbsp;&nbsp;&nbsp;&nbsp;{{$order->shipping->fname}} {{$order->shipping->lname}}</span><br/>
        @else
          <h5>Company: </h5><span class="value">&nbsp;&nbsp;&nbsp;&nbsp;{{$order->shipping->cname}}</span><br/>
          <h5>TRN No: </h5><span class="value">&nbsp;&nbsp;&nbsp;&nbsp;{{$order->shipping->trn_no}}</span><br/>
        @endif
          <h5>Phone: </h5><span class="value">&nbsp;&nbsp;&nbsp;&nbsp;+ {{$shipping_city->country->calling_code}} {{$order->shipping->phone}}</span><br/>
          <h5>Address: </h5><span class="value">&nbsp;&nbsp;&nbsp;&nbsp;{{$order->shipping->address}}, {{$shipping_city->name}},<br/> {{$shipping_city->state->name}}, {{$shipping_city->country->name}}</span><br/>
      </div>
    </div>

    @php 
      $i = 0;
      $sum = $order->order_items->sum('total');
    @endphp

    <section class="order-details">
      <div class="table-title">
        <h3>Order Details</h3>
      </div>
      <table class="table details-table">
        <thead>
          <tr>
            <th scope="col" class="col-6">S.NO</th>
            <th scope="col" class="col-6">PRODUCT</th>
            <th scope="col" class="col-3">FORM</th>
            <th scope="col" class="col-3">SIZE</th>
            <th scope="col" class="col-3">QTY.</th>
            <th scope="col" class="col-3">PRICE</th>
            <th scope="col" class="col-3">AMOUNT<br/><span>(EXCLUDING VAT)</span></th>
            <th scope="col" class="col-3">VAT %</th>
            <th scope="col" class="col-3">VAT AMOUNT</th>
            <th scope="col" class="col-3">Discount</th>
            <th scope="col" class="col-3">AMOUNT<br/><span>(INCLUDING VAT)</span></th>
          </tr>
        </thead>
        <tbody>
       
        @foreach($order->order_items as $order_item)
        @php 
          $product=DB::table('products')->select('name')->where('id',$order_item->product_id)->first();
          $i++;
        @endphp
          <tr>
            <td>{{$i}}</td>
            <td>
              {{$product->name}}
            </td>
            <td>{{$order_item->form}}</td>
            <td>{{$order_item->size}}</td>
            <td>{{$order_item->quantity}}</td>
            <td>AED {{number_format($order_item->price, 2)}}</td>
            <td>AED {{number_format($order_item->subtotal, 2)}}</td>
            <td>5%</td>
            <td>AED {{number_format($order_item->tax, 2)}}</td>
            <td>AED {{number_format($order_item->discount, 2)}}</td>
            <td>AED {{number_format($order_item->total, 2)}}</td>
          </tr>
        @endforeach
        </tbody>
        <tfoot>
          <tr>          
            <th scope="col" colspan="6">Total</th>
            <th scope="col">AED {{number_format($order->payment->subtotal, 2)}}</th>
            <th scope="col"></th>
            <th scope="col">AED {{number_format($order->payment->tax, 2)}}</th>        
            <th scope="col">AED {{number_format($order->payment->discount, 2)}}</th>        
            <th scope="col">AED {{number_format($sum, 2)}}</th>        
          </tr>
        </tfoot>
      </table>
      <div class="summary clearfix">
        <h5>Subtotal: </h5><span class="value">AED {{number_format($order->payment->subtotal, 2)}}</span><br/>
        <h5>VAT Amount: </h5><span class="value">AED {{number_format($order->payment->tax, 2)}}</span><br/>
        <h5>Discount: </h5><span class="value">AED {{number_format($order->payment->discount, 2)}}</span><br/>
        <h5>Shipping: </h5><span class="value">AED {{number_format($order->payment->shipping, 2)}}</span><br/>
        <hr/>
        <h4>Grand Total: </h4><span class="value">AED {{number_format($order->payment->total, 2)}}</span><br/>
      </div>
      <div class="footer">
        This is an e-generated invoice.
      </div>
    </section>
  </body>
</html>