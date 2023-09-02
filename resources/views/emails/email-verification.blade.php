<x-mail::message>
Dear **{{$full_name}}**!

Welcome to **HerbalCare**, the ultimate destination for all-natural goodness! <br>

We're so glad you've decided to join our community of herb lovers and natural beauty enthusiasts. As a registered member, you'll now get exclusive access to all kinds of special offers and early access to new products, and insider info on all our latest natural products. <br>

As a member of **HerbalCare**, you're  joining a community of people who believe in the power of natural goodness. We're here to help you on your journey to a healthier, more natural lifestyle, and we can't wait to see what you accomplish. <br>

So go ahead and explore all that **HerbalCare** has to offer.@if($password) Your email address and password is

<x-mail::panel>
**Email:** {{$email}} <br>
**Password:** {{$password}}
</x-mail::panel>

@endif

Please click the button below to verify your email address.

<x-mail::button :url="$url">
Verify Email Address
</x-mail::button>

Thanks again for joining us on this journey. We're thrilled to have you as part of the **HerbalCare** family!

Regards,<br>
**{{ config('app.name') }}**
</x-mail::message>
