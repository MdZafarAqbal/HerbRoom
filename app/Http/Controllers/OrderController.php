<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Mail\OrderCancel;

use App\Mail\OrderReturn;
use App\Models\CancelItem;
use App\Models\CartItem;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ReturnItem;
use App\Models\Shipping;
use App\Notifications\StatusNotification;
use App;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Hash;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;
use Notification;
use PDF;
use Session;

class OrderController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $orders = Order::orderBy('id', 'DESC')->paginate(10);
    return view('admin.order.index')->with('orders',$orders);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $order = Order::find($id);
    return view('admin.order.show')->with('order', $order);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $order = Order::find($id);
    return view('admin.order.edit')->with('order',$order);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    $current_date = Carbon::now()->toDateString();
    $order = Order::with('shipping', 'payment')->find($id);

    if($request->shipping_status == 'processed') {
      $order->shipping->processed = $current_date;

      $response = Http::acceptJson()->withHeaders([
        'Cache-Control' => 'no-cache'
      ])->withToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOiIxNjgwOTQyNzQzIiwiaXNzIjoiaHR0cHM6Ly9za3lleHByZXNzaW50ZXJuYXRpb25hbC5jb20iLCJhdWQiOiJodHRwczovL3NreWV4cHJlc3NpbnRlcm5hdGlvbmFsLmNvbSIsImV4cCI6IjE3NjczNDI3NDMiLCJ1bmFtZSI6IkFXNDc1MDEiLCJ1aWQiOiI0ZmFmNTIzZjMzMDk0YzA1YjYyNGYxMzIwMTcwODMzZSJ9.kyJooKHXR7jnJLYVvNG9UOyZtGBXYr7gYZiJSsAAjbE')
      ->post('https://www.skyexpressinternational.com/api/Booking/ReadyForPickup', [$order->shipping->awb_no]);
    }
    
    if($request->shipping_status == 'shipped')
      $order->shipping->shipped = $current_date;
    
    if($request->shipping_status == 'delivered') 
      $order->shipping->delivered = $current_date;

    $order->status = $request->order_status;
    $order->payment->status = $request->payment_status;
    $order->shipping->status = $request->shipping_status;

    $order->save();
    $order->shipping->save();
    $order->payment->save();
      
    return redirect()->route('orders.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $order=Order::find($id);
    if($order){
      $deleted=$order->delete();
      if($deleted){
        request()->session()->flash('success','Order Successfully deleted');
      }
      else{
        request()->session()->flash('error','Order can not deleted');
      }
      return redirect()->route('orders.index');
    }
    else{
      request()->session()->flash('error','Order can not found');
      return redirect()->back();
    }
  }

  public function userOrders (Request $request) {
    if(Auth::check()) {
      $orders = Order::with('payment')->where('user_id', Auth()->user()->id)->orderBy('created_at', 'desc')->get();
      
      if($orders->isEmpty()) {
        $orders = false;
      }
    } else {
      $orders = false;
    }
    
    return view('main.pages.orders')->with('orders', $orders);
  }

  public function orderDetail (Request $request) {
    if(!$request->order_no) {
      return back()->with('error', 'Invalid order no');
    }

    $order = Order::with('payment', 'shipping')->where('order_no', $request->order_no)->first();

    if($order) {
      $shipping = $order->shipping;
      $cancel = false;
      $return = false;
      $date = Carbon::now()->subDays(15)->toDateString();
      
      if($shipping->status == 'ordered' && $shipping->shipped == null ) {
        $cancel = true;
      }

      if ($order->status == 'completed') {
        if($shipping->delivered > $date) {
          $return = true;
        }
      }
    }
    else {
      return back()->with('error', 'Invalid order no');
      $cancel = false;
      $return = false;
      $order = false;
    }

    return view('main.pages.order-detail')->with(['order' => $order, 'return' => $return, 'cancel' => $cancel]);
  }

  public function trackOrder(Request $request) {
    $order = Order::with('shipping')->where('order_no', $request->order_no)->first();

    return view('main.pages.order-track')->with('order', $order);
  }

  public function actionView(Request $request) {
    $order = Order::with('order_items')->where('order_no', $request->order_no)->first();
    $cancel = false;
    $return = false;

    if($request->cancel) {
      $cancel = true;
    }

    if($request->return) {
      $return = true;
    }

    return view('main.pages.order-action')->with(['order' => $order, 'cancel' => $cancel, 'return' => $return]);
  }

  // Email confirmation for cancel items
  public function actionEmail(Request $request) {
    $code = random_int(100000, 999999);
    $hash = Hash::make($code);
    Session::put('code', $hash);
    $order = Order::findOrFail($request->id);
    
    if($request->action == 'cancel') {
      Mail::to($order->email)->send(new OrderCancel($order, $code));
    }
    elseif($request->action == 'return') {
      Mail::to($order->email)->send(new OrderReturn($order, $code));
    }
  }
  
  // Cancel order items
  public function cancelOrder(Request $request) {
    $order = Order::with('payment', 'order_items', 'shipping.city')->where('id', $request->id)->first();
    
    if(Hash::check($request->otp, Session::get('code'))) {
      if($request->all == 1) {
        $order->status = 'cancelled';
        foreach($order->order_items as $item) {
          $properties = collect($item->toArray())->only(['order_id', 'attr_id', 'quantity', 'discount', 'total'])->all();
          
          $cancel = new CancelItem;
          $cancel->fill($properties);
          $cancel->reason = $request->reason;
          
          $order->payment->cancelled += $cancel->total;
          $order->payment->subtotal -= $item->subtotal;
          $order->payment->tax -= $item->tax;
          $order->payment->discount -= $item->discount;
          $order->payment->total = $order->payment->subtotal + $order->payment->tax - $order->payment->discount;
          
          $cancel->save();
          $item->delete();
        }
        
        $order->save();
      } else {
        foreach($request->items as $id) {
          $item = $order->order_items->find($id);
          $properties = collect($item->toArray())->only(['order_id', 'attr_id', 'quantity', 'discount', 'total'])->all();
          
          $cancel = new CancelItem;
          $cancel->fill($properties);
          $cancel->reason = $request->reason;
          
          $order->payment->cancelled += $cancel->total;
          $order->payment->subtotal -= $item->subtotal;
          $order->payment->tax -= $item->tax;
          $order->payment->discount -= $item->discount;
          $order->payment->total = $order->payment->subtotal + $order->payment->tax - $order->payment->discount;
          
          $cancel->save();
          $item->delete();
        }
      }
      
      if($order->payment->total > 0 && $order->payment->total < 100) {
        $order->payment->shipping = $order->shipping->city->shipping;
      } else {
        $order->payment->shipping = 0;
      }
      
      if($order->payment->status == 'paid') {
        $order->payment->refund = $order->payment->cancelled - $order->payment->shipping;
      }
      
      $order->payment->total += $order->payment->shipping;
      $order->payment->save();
      $request->session()->flash('success', 'Item cancelled successfully.');
      return;
    } else {
      return ('Incorrect OTP');
    }
  }
  
  // Return order items
  public function returnOrder(Request $request) {
    $order = Order::with('payment', 'order_items', 'shipping.city')->where('id', $request->id)->first();

    if(Hash::check($request->otp, Session::get('code'))) {
      if($request->all == 1) {
        $order->status = 'returned';
        foreach($order->order_items as $item) {
          $properties = collect($item->toArray())->only(['order_id', 'attr_id', 'quantity', 'discount', 'total'])->all();

          $return = new ReturnItem;
          $return->fill($properties);
          $return->reason = $request->reason;

          $order->payment->returned += $return->total;
          $order->payment->subtotal -= $item->subtotal;
          $order->payment->tax -= $item->tax;
          $order->payment->discount -= $item->discount;
          $order->payment->shipping = $order->shipping->city->shipping;
          $order->payment->total = $order->payment->subtotal + $order->payment->tax - $order->payment->discount;

          $return->save();
          $item->delete();
        }

        $order->save();
      } else {
        foreach($request->items as $id) {
          $item = $order->order_items->where('id', $id)->first();
          $properties = collect($item->toArray())->only(['order_id', 'attr_id', 'quantity', 'discount', 'total'])->all();

          $return = new ReturnItem;
          $return->fill($properties);
          $return->reason = $request->reason;

          $order->payment->returned += $return->total;
          $order->payment->subtotal -= $item->subtotal;
          $order->payment->tax -= $item->tax;
          $order->payment->discount -= $item->discount;
          $order->payment->total = $order->payment->subtotal + $order->payment->tax - $order->payment->discount;
          
          $return->save();
          $item->delete();
        }
      }

      if($order->payment->total >= 0 && $order->payment->total < 100) {
        $order->payment->shipping = $order->shipping->city->shipping;
      } else {
        $order->payment->shipping = 0;
      }

      if($order->payment->status == 'paid') {
        $order->payment->refund = $order->payment->returned - $order->payment->shipping;
      }

      $order->payment->total += $order->payment->shipping;
      $order->payment->save();
      $request->session()->flash('success', 'Item added to return process successfully.');
      return;
    } else {
      return ('Incorrect OTP');
    }
  }

  // Sale invoice generate
  public function saleInvoice(Request $request, Order $order) {
    // $order = Order::with('order_items', 'payment', 'shipping')->find($id);
    $file_name = $order->order_no.'-'.$order->fname.'.pdf';
    
    $pdf = App::make('dompdf.wrapper');
    $pdf->setPaper('A4', 'portrait');
    $pdf->loadView('main.order.sale-invoice', compact('order'));

    if($request->download == 1) {
      return $pdf->download($file_name);
    }
    
    return $pdf->output();
  }

  // Tax invoice generate
  public function taxInvoice(Request $request, Order $order) {
    // $order = Order::with('order_items', 'payment', 'shipping')->find($id);
    $file_name = $order->order_no.'-'.$order->fname.'.pdf';
    
    $pdf = PDF::loadview('main.order.tax-invoice', compact('order'));

    if($request) {
      if($request->download == 1)
        return $pdf->download($file_name);
    }
    
    return $pdf->output();
  }

  /**
   * Generate unique code for orders
   *
   * @return response()
   */
  public function generateUniqueCode()
  {
    do {
      $code = random_int(1000000, 9999999);
    } while (Order::where("order_no", $code)->first());

    return $code;
  } 

  // Income chart
  public function incomeChart(Request $request){
    $year=\Carbon\Carbon::now()->year;
    // dd($year);
    $items=Order::with(['order_items'])->whereYear('created_at',$year)->where('status','completed')->get()
        ->groupBy(function($d){
            return \Carbon\Carbon::parse($d->created_at)->format('m');
        });
        // dd($items);
    $result=[];
    foreach($items as $month=>$item_collections){
      //dd($items);
        foreach($item_collections as $item){
            $amount=$item->order_items->sum('total');
            $m=intval($month);
            isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
        }
    }
    $data=[];
    for($i=1; $i <=12; $i++){
        $monthName=date('F', mktime(0,0,0,$i,1));
        $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
    }
    return $data;
  }
}
?>
