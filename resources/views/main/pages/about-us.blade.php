@extends('main.layouts.master')

@section('title', 'About Us || HerbalCare')

@push('styles')
  <link rel="stylesheet" href="{{asset('css/main/about-us.min.css')}}">
@endpush

@section('main-content')
	<!-- About Us -->
	<section class="about-us">
    @php
      $data = DB::table('settings')->first();
    @endphp
    <div class="about-img">
      <img src="{{asset('images/about-us1.jpg')}}" alt="About Us image of herbs">
      <img src="{{$data->photo}}" alt="About Us image of herbs">
    </div>
    <div class="about-content">
      <h2>Welcome to <span>HerbalCare!</span></h2>
      <p>We welcome you to the <strong>Botanical</strong> World of Herbs.</p>
      <p>We provide exquisite <strong>Herbs, Teas, Oils and Extracts</strong> of exceptional character of rich underlying attributes since 1980.</p>
      <p>We at <strong>HerbalCare.ae</strong> handpicked all the herbs in their natural forms. No artificial chemical or any other substitute is added to any of our product. All the herbs which we collect are sorted, processed and cleaned by the old proven natural traditional methods, which guarantee natural taste and purity.</p>
      <p>We store all the goods in a hygienic way so that its curing values are not impacted.</p>
      <p>Herbs have been a quintessential part of the well-being of man since the ancient times. We take pride in beig the largest inventory holders of more than 2000 exquisite herbs procured from their origins at its best from around the world.</p>
      <p>We have a strong foothold in the international as well as the domestic market in terms of respect, acknowledgement and appreciation in the herbal community around the globe.</p>
      <p>Indulging in the products from the Middle East, India, Africa, Canada, Indonesia, China, Pakistan, Thailand, Hong Kong, New Zealand, Australia and numerous other countries, we as a brand have gained new perspectives.</p>
      <p>We take pride in our work and this has leaded us to a yet another step in its mushrooming, hence an online portal to cater the myriad needs of our consumers.</p>
      <p>Feel free to explore and let us know if you have any queries.</p>
    </div>
	</section>
	<!-- End About Us -->
@endsection
