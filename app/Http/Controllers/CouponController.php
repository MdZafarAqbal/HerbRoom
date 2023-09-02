<?php

namespace App\Http\Controllers;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CartItem;
use Auth;

class CouponController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    $coupon=Coupon::with('products')->orderBy('id','DESC')->paginate('10');
    return view('admin.coupon.index')->with('coupons',$coupon);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function create() {
    return view('admin.coupon.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // return $request->all();
    $this->validate($request,[
      'code'=>'string|required',        
      'type'=>'required|in:fixed,percent',
      'value'=>'required|numeric',
      'effect'=>'required|in:product,category,subcategory,user,all',
    ]);
    $data=$request->all();
    //dd($request->all());
    $status=Coupon::create($data);
    if($status){
        request()->session()->flash('success','Coupon Successfully added');
    }
    else{
        request()->session()->flash('error','Please try again!!');
    }
    return redirect()->route('coupons.index');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $coupon=Coupon::with('products')->with('users')->find($id);
    if($coupon){
        return view('admin.coupon.edit')->with('coupon',$coupon);
    }
    else{
        return view('admin.coupon.index')->with('error','Coupon not found');
    }
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
    $coupon=Coupon::findOrFail($id);
    $this->validate($request,[
        
    ]);
    //dd($request->all());
    $data=$request->all();
    //dd($coupon);
    $status=$coupon->fill($data)->save();
    if($status){
        request()->session()->flash('success','Coupon Successfully updated');
    }
    else{
        request()->session()->flash('error','Please try again!!');
    }
    return redirect()->route('coupons.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $coupon=Coupon::find($id);
    if($coupon){
      $status=$coupon->delete();
      if($status){
          request()->session()->flash('success','Coupon successfully deleted');
      }
      else{
          request()->session()->flash('error','Error, Please try again');
      }
      return redirect()->route('coupons.index');
    }
    else{
      request()->session()->flash('error','Coupon not found');
      return redirect()->back();
    }
  }

  public function storeCoupon(Request $request){
    // return $request->all();
    $today = today('Europe/London');
    $coupon=Coupon::with('products')->where('code',$request->code)->first();
        
    // dd($coupon);
    if(!$coupon){
      request()->session()->flash('error','Invalid coupon code, Please try again');
      return back();
    }
    if($coupon){
      if($coupon->user_id == auth()->user()->id){     
        $total_price=CartItem::where('user_id',auth()->user()->id)->where('order_id',null)->sum('price');           
        session()->put('coupon', [
          'id'=>$coupon->id,
          'code'=>$coupon->code,
          'value'=>$coupon->discount($total_price)
        ]);
      }
      else if($coupon->product_id){
        if($coupon->product_id == $coupon->products->id)
        $total_price=CartItem::where('user_id',auth()->user()->id)->where('order_id',null)->sum('price');
        session()->put('coupon',[
            'id'=>$coupon->id,
            'code'=>$coupon->code,
            'value'=>$coupon->discount($total_price)
        ]);
      }
      else if($today <= $coupon->expiry_date){
        $total_price=CartItem::where('user_id',auth()->user()->id)->where('order_id',null)->sum('price');
        session()->put('coupon',[
            'id'=>$coupon->id,
            'code'=>$coupon->code,
            'value'=>$coupon->discount($total_price)
        ]);
      }
      
      request()->session()->flash('success','Coupon successfully applied');
      return redirect()->back();
    }
  }

  public function applyCoupon(Request $request) {
    $coupon_code = strtoupper($request->coupon_code);
    $coupon = Coupon::where('code', $coupon_code)->first();
    $discount = 0;

    if(Auth::check()) {
      $cart_items = CartItem::where('user_id', Auth()->user()->id)->get();
      foreach($cart_items as $cart) {
        if($cart->coupon_id) {
          return response()->json('Coupon already applied on this order', 400);
        }
      }

      if(!$coupon) {
        return response()->json('Invalid Coupon', 400);
      }

      if($coupon->effect == 'product') {
        $carts = CartItem::with('product')->where('user_id', Auth()->user()->id)->get();
        foreach($carts as $cart) {
          if($cart->product->coupon_id == $coupon->id) {
            if($coupon->type == 'percent') {
              $coupon_discount = $cart->total * $coupon->value / 100;
              $cart->discount += $coupon_discount;
              $cart->total -= $coupon_discount;
              $cart->coupon_id = $coupon->id;
            }
            $cart->save();
          }
        }
      } elseif($coupon->effect == 'category') {
        $carts = CartItem::with('product.categories')->where('user_id', Auth()->user()->id)->get();
        foreach($carts as $cart) {
          foreach($cart->product->categories as $category) {
            if($category->coupon_id == $coupon->id) {
              if($coupon->type == 'percent') {
                $coupon_discount = $cart->total * $coupon->value / 100;
                $cart->discount += $coupon_discount;
                $cart->total -= $coupon_discount;
                $cart->coupon_id = $coupon->id;
              }
              $cart->save();
            }
          }
        }
      } elseif($coupon->effect == 'subcategory') {
        $carts = CartItem::with('product.subcat')->where('user_id', Auth()->user()->id)->get();
        foreach($carts as $cart) {
          foreach($cart->product->subcat as $subcat) {
            if($subcat->coupon_id == $coupon->id) {
              if($coupon->type == 'percent') {
                $coupon_discount = $cart->total * $coupon->value / 100;
                $cart->discount += $coupon_discount;
                $cart->total -= $coupon_discount;
                $cart->coupon_id = $coupon->id;
              }
              $cart->save();
            }
          }
        }
      } elseif($coupon->effect == 'user') {
        $carts = CartItem::with('user')->where('user_id', Auth()->user()->id)->get();
        foreach($carts as $cart) {
          if($cart->user->coupon_id == $coupon->id) {
            if($coupon->type == 'percent') {
              $coupon_discount = $cart->total * $coupon->value / 100;
              $cart->discount += $coupon_discount;
              $cart->total -= $coupon_discount;
              $cart->coupon_id = $coupon->id;
            }
            $cart->save();
          }
        }
      } elseif($coupon->effect == 'all') {
        $carts = CartItem::where('user_id', Auth()->user()->id)->get();
        foreach($carts as $cart) {
          if($coupon->type == 'percent') {
            $coupon_discount = $cart->total * $coupon->value / 100;
            $cart->discount += $coupon_discount;
            $cart->total -= $coupon_discount;
            $cart->coupon_id = $coupon->id;
          }
          $cart->save();
        }
      }
      return back();
    }
    else {
      return response()->json('Please register to apply coupon.', 400);
    }
  }
}
