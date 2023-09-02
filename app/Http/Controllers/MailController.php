<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
  public function send_mail($email, $pdf)
  {
    $data['email'] = $email;
    $data['title'] = config('app.name', 'HerbalCare');

    Mail::send('emails.orders.confirmation', $data, function($message)use($data, $pdf) {
      $message->to([$data['email'], 'order@herbalcare.ae'])->subject($data["title"]);

      $message->attachData($pdf, 'order_details.pdf');         
    });
  }

  public function cancel_mail($email, $otp) {
    Mail::send('main.order.cancel-mail', $data, function($message)use($email, $pdf) {
      $message->to($email)->subject('Order Cancel Confirmation');

      $message->attachData($pdf, 'order_details.pdf');         
    });

    Mail::send('main.order.mail', $data, function($message)use($data, $pdf) {
      $message->to("admin@herbalcare.ae")->subject($data["title"]);

      $message->attachData($pdf, 'order_details.pdf');         
    });
  }
}
