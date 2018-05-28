@extends('layouts.app')
@section('content')
  @php
  $carousel_items = json_decode(get_theme_mod('theme_front_page_carousel-items'));
  @endphp
  @if($carousel_items)
  <div class="owl-carousel owl-theme">
    @foreach($carousel_items as $item)
      <div class="item"><img src="{{ $item->image_url }}"></div>
    @endforeach
  </div>
  @endif
  <div class="front-page-intro">
    <div class="row">
      <div class="col-md-8">
      	<h4>Hello...</h4>
      	<p>
      		Welcome to Blackwater Cottage our family run bed and breakfast nestled in the Blackdown Hills between the A303 and the M5.
    		  We, Diana and Julian and our 2 dogs Tarka and Rori will be there on arrival to provide you with a warm welcome including tea and homemade biscuits.
    		  We have 3 lovely rooms on offer including a locally sourced full English Breakfast in the family kitchen/dining area.
    		  We aim to provide you with a home from home feeling in a beautiful location where you can relax and enjoy the surroundings.
    	  </p>
      </div>
      <div class="col-md-4">
      	<div class="quote">
          <div class="quote-bubble">
            <div class="quote-text">
              <p>A beautiful B&B in a stunning location. Diana’s scones were to die for.</p>
            </div>
          </div>
          <span class="quote-author">Oliver  Davies</span>
    	   </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <a href="#">
      <div class="button-card">
        <img src="http://2q3xk01vwwv9vh0d04dce42y.wpengine.netdna-cdn.com/wp-content/uploads/2018/01/1-1024x683.jpg" alt="Rooms">
        <button class="btn btn-primary">View The Rooms</button>
      </div>
      </a>
    </div>
    <div class="col-md-4">
      <div class="button-card">
        <img src="http://2q3xk01vwwv9vh0d04dce42y.wpengine.netdna-cdn.com/wp-content/uploads/2018/01/1-1024x683.jpg" alt="Rooms">
        <button class="btn btn-primary">View The Rooms</button>
      </div>
    </div>
    <div class="col-md-4">
      <div class="button-card">
        <img src="http://2q3xk01vwwv9vh0d04dce42y.wpengine.netdna-cdn.com/wp-content/uploads/2018/01/1-1024x683.jpg" alt="Rooms">
        <button class="btn btn-primary">View The Rooms</button>
      </div>
    </div>
  </div>
  <script>
    $('.owl-carousel').owlCarousel({
      loop:true,
      autoWidth:true,
      items:1
    });
  </script>
  <style>
    .owl-carousel .item{
      height:285px;
      width:100%;
    }
    .owl-carousel .item img {
      width: 100%;
      zoom: 1.2;
    }
  </style>
@endsection
