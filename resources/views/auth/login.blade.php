<!DOCTYPE html>
  <html lang="en-US">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="height=device-height, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">

    <title>Sign In || HerbalCare</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset('images/favicon.png')}}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700;1,900&family=Vollkorn:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- HerbalCare StyleSheet -->
    <link href="{{asset('css/main/signin-up.min.css')}}" rel="stylesheet">
  </head>
  <body>
    <section class="shop-signing login-section">
      <div class="signing-img-container"></div>
      <div class="signing-form-container">
        @include('layouts.flash-message')

        <a href="{{ route('home') }}"><img src="{{asset('images/logo_green.png')}}" alt="HerbalCare Website Logo" class="signing-web-logo"></a>
        <h1 class="signing-web-title"><a href="{{ route('home') }}">HerbalCare</a></h1>
        <h2>Sign In</h2>

        <!-- Form -->
        <form class="form" method="post" action="{{ route('login') }}" novalidate>
          @csrf

          @if($checkout)
            <input type="hidden" name="checkout" value="true">
          @endif
          <div class="form-group">
            <div class="form-input">
              <input type="email" name="email" id="email" placeholder="someone@domain.com" value="{{ old('email') }}">
              <label for="email">Email</label>
            </div>

            @if ($errors->has('email'))
              <div class="error">
                @error('email')
                  {{$message}}
                @enderror
              </div>
            @endif
          </div>
        
          <div class="form-group">
            <div class="form-input">
              <input type="password" name="password" id="password" placeholder="Enter Password" value="{{ old('password') }}">
              <label for="password">Password</label>
            </div>

            @if ($errors->has('password'))
              <div class="error">
                @error('password')
                  {{ $message }}
                @enderror
              </div>
            @endif
          </div>

          <div class="remember-checkbox">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Remember Me</label>
          </div>

          <div class="form-group submit-btn">
            <button class="btn signing-btn" type="submit">Login</button>
          </div>
        </form>    
        <p>Don't have an account? <a href="{{ route('register.view') }}" class="btn">Sign Up</a></p>
        @if (Route::has('reset.password'))
          <p><a class="forgot-pass" href="{{ route('reset.password') }}">
            Forgot password?
          </a></p>
        @endif        
        <p>Goto <a href="{{ route('home') }}" class="btn">Homepage</a></p>
      </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.2.min.js"></script>
    <script src="{{asset('js/main/login.min.js')}}"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NH2TVFJYP0"></script>
    <script>function gtag(){dataLayer.push(arguments)}window.dataLayer=window.dataLayer||[],gtag("js",new Date),gtag("config","G-NH2TVFJYP0");</script>
  </body>
</html>
