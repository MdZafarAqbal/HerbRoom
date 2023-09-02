<x-mail::message>
# Return Confirmation

We have received your request for the return of order items. Your otp code to confirm the return request is given below. 

<x-mail::panel>
  ## {{$code}}
</x-mail::PANEL>

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
