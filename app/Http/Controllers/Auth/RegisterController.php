<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\CartItem;
use App\Models\User;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = 'verify-page';

  /**
   * Create a new controller instance.
   *
   * @return void
  */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
   * Provision a new web server.
   */
  public function __invoke(Request $request) {
    $validated = $request->validate([
      'cust_type' => ['required', 'string'],
      'fname' => ['required_if:cust_type,individual', 'regex:/^[\p{L}\p{M} ]*[\p{L}\p{M}]{1,}[\p{L}\p{M} ]*[\p{L}\p{M}]{1,}$/u', 'nullable'],
      'lname' => ['required_if:cust_type,individual', 'regex:/^[\p{L}\p{M} ]*[\p{L}\p{M}]{1,}[\p{L}\p{M} ]*[\p{L}\p{M}]{1,}$/u', 'nullable'],
      'cname' => ['required_if:cust_type,company', 'string', 'min:3', 'nullable'],
      'trn_no' => ['required_if:cust_type,company', 'min_digits:15', 'nullable'],
      'email' => ['required', 'email:strict,dns', 'unique:users'],
      'password' => ['required', 'confirmed', Password::min(8)
        ->letters()
        ->numbers()
        ->symbols()
      ],
    ]);

    $fname = ucwords(strtolower($request->fname));
    $lname = ucwords(strtolower($request->lname));
    $cname = ucwords(strtolower($request->cname));

    $user = User::create([
      'fname' => $fname,
      'lname' => $lname,
      'cname' => $cname,
      'trn_no' => $request->trn_no,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]); 
    
    if($user){
      $request->session()->put('user', $request->email);
      
      if($request->user()->cname)
        $request->session()->put('cname', $request->user()->cname);
      else {
        $request->session()->put('fname', $request->user()->fname);
        $request->session()->put('lname', $request->user()->lname);
      }

      Auth::attempt(['email' => $request->email, 'password' => $request->password]);
      $cart_items = session('cart');

      foreach($cart_items as $item) {
        $attr = Attribute::with('product.cats', 'product.subcats')->find($item->attr_id);
        $discount = 0;

        $cart = new CartItem;
        $cart->user_id = $request->user()->id;
        $cart->attr_id = $item->attr_id;
        $cart->quantity = $item->quantity;
        $cart->total = $attr->price * $cart->quantity;
        $cart->subtotal = $cart->total / 1.05;
        $total = $cart->subtotal;
        
        $discount += $total / 10;
        $total -= $discount;

        $cart->tax = $total * 0.05;
        $cart->discount = $discount;
        $cart->total = $total + $cart->tax;
        $cart->save();
      }

      $request->session()->forget(['id', 'cart']);
      $request->session()->regenerate();

      event(new Registered($user, $request->password));
      return redirect()->route('verification.view')->with('success', 'Thankyou for registration. Please verify your email.');
    }

    else{
      return back()->with('error', 'Something went wrong. Please try again!');
    }
  }
}
