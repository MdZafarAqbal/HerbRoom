<?php
/**
 * 
 * Stripe Setting & API Credentials
 */

return [
  /*
  |--------------------------------------------------------------------------
  | Stripe Public Key
  |--------------------------------------------------------------------------
  |
  | Use this key, when you’re ready to launch your app, 
  | in your web or mobile app’s client-side code.
  |
  */

  'stripe_key' => env('STRIPE_KEY'),
    
  /*
  |--------------------------------------------------------------------------
  | Stripe Secret Key
  |--------------------------------------------------------------------------
  |
  | Use this key to authenticate requests on your server. 
  | By default, you can use this key to perform any API request without restriction.
  |
  */

  'stripe_secret' => env('STRIPE_SECRET'),
];
