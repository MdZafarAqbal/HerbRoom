<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Email Verification Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling email verification for any
  | user that recently registered with the application. Emails may also
  | be re-sent if the user didn't receive the original email message.
  |
  */

  use VerifiesEmails;

  /**
   * Where to redirect users after verification.
   *
   * @var string
  */
  protected $redirectTo = '/home';

  /**
   * Email Verification Handler.
   *
   *
   *
   * @return view
  */
  public function verifyEmail(EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
  }

  /**
   * Resending a Verification Email.
   *
   *
   *
   * @return view
  */
  public function resendVerificationEmail (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
  }
}
