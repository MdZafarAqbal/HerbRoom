<!DOCTYPE html>
<html lang="en-us">
  <head>
		@include('main.layouts.head')	
  </head>
  <body>
		<!-- Header -->
		@include('main.layouts.header')
		<!-- End Header -->

    @include('layouts.flash-message')
    
    <section id="main-content">
		  @yield('main-content')
    </section>

		<!-- Footer -->
		@include('main.layouts.footer')
		<!-- End Footer -->

		<!-- Scripts -->
		<script src="{{asset('js/main/header.min.js')}}"></script>
		<script src="{{asset('js/main/main.min.js')}}"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NH2TVFJYP0"></script>
    <script>function gtag(){dataLayer.push(arguments)}window.dataLayer=window.dataLayer||[],gtag("js",new Date),gtag("config","G-NH2TVFJYP0");</script>
		@stack('scripts')
		<!-- End Scripts -->
  </body>
</html>