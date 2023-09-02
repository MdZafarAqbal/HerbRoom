<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="height=device-height, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">

    <title>Verify Email || HerbalCare</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset('images/favicon.png')}}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Vollkorn:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!-- HerbalCare StyleSheet -->
    <link href="{{asset('css/main/verify-email.min.css')}}" rel="stylesheet">
  </head>

  <body>
    <header class="header web-header" id="header">
      <a href="{{route('home')}}" class="header-logo">
        <img src="{{asset('images/logo.png')}}" alt="Website Logo" class="signing-web-logo">
      </a>
      <h2 class="header-title">HerbalCare</h2>
      <a class="user-nav" href="{{ route('logout.user') }}"><i class="fa-solid fa-right-from-bracket icon" id="logout-icon"></i></a>
    </header>

    @include('layouts.flash-message')

    <section class="email-verify-section">
      <div class="img-container">
        <img src="{{asset('images/verify_email.png')}}" alt="Verify Email Mockup Image">
      </div>
      <div class="verify-card">
          <div class="card-header"><h3>Verify Your Email Address</h3></div>

          <div class="card-body">
            <p>Before proceeding further, please check your email for a verification link.</p>
            <p>If you did not receive the email, please click the link below.</p>

            <form class="resend-form" method="POST" action="{{ route('verification.resend') }}">
              @csrf
              <button type="submit" class="btn-submit">Resend Email</button>
            </form>
          </div>
      </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.2.min.js"></script>
    <script>
      $(function() {
        $('.flash-message').css('opacity', 0);
        setTimeout(function() {
          $('.flash-message').remove();
        }, 4100);
      });
    </script>
  </body>
</html>
