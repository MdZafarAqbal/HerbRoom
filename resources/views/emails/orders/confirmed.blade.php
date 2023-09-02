<x-mail::message>
# Order Confirmation

@if($order->cname)
Respected **{{$order->cname}}**!
@else
Dear **{{$order->fname . ' ' . $order->lname}}**
@endif

Thank you for placing an order with **HerbalCare**. We are thrilled to provide you with the finest quality naturals.

Your order has been received and is currently being processed. Your order details are attached as a pdf file with this email.

If you have any questions or concerns, please don't hesitate to reach out to us. We are always here to help.

Thank you once again for choosing **HerbalCare**.

Regards,<br>
{{ config('app.name') }}
</x-mail::message>