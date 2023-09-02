<x-mail::message>
# Cancel Confirmation

We have received your request for the cancellation of order items. Your otp code to confirm the cancellation request is given below. 

<x-mail::panel>
  ## {{$code}}
</x-mail::PANEL>

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
