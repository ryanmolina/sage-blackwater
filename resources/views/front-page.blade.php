@extends('layouts.app')
@section('content')
  <div class="owl-carousel owl-theme">
      <div class="item"><img src="https://blackwatercottage.hotelpropeller.com/files/2013/08/Tea1-938x349.jpg"></div>
      <div class="item"><img src="https://blackwatercottage.hotelpropeller.com/files/2013/08/Flowers1-938x349.jpg"></div>
      <div class="item"><img src="https://blackwatercottage.hotelpropeller.com/files/2013/08/Tea1-938x349.jpg"></div>
      <div class="item"><img src="https://blackwatercottage.hotelpropeller.com/files/2013/08/Bed-938x349.jpg"></div>
  </div>
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
        <div class="talk-bubble tri-right round btm-left">
          <div class="talktext">
            <p>A beautiful B&B in a stunning location. Diana’s scones were to die for.</p>
          </div>
        </div>
        <span class="talktext-author">Oliver  Davies</span>
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

  <style>
  /* CSS talk bubble */
  .quote {
    position: relative;
  }

  .talktext-author {
    position: absolute;
    bottom: -25px;
    left: 60px;
  }

  .talk-bubble {
    display: inline-block;
    position: relative;
    background-color: lightyellow;
  }

  .round {
    border-radius: 30px;
    -webkit-border-radius: 30px;
    -moz-border-radius: 30px;

  }

  /*Right triangle, placed bottom left side slightly in*/
  .tri-right.btm-left:after {
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
    left: 15px;
    right: auto;
    top: auto;
    bottom: -20px;
    border: 20px solid;
    border-color: lightyellow lightyellow transparent transparent ;
  }

  /* talk bubble contents */
  .talktext {
    padding: 1em;
    text-align: left;
    line-height: 1.5em;
  }

  .talktext p {
    /* remove webkit p margins */
    -webkit-margin-before: 0em;
    -webkit-margin-after: 0em;
  }

  .button-card {
    position: relative;
  }

  .button-card:before {
    content: "";
    display: block;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(32, 36, 86, 0.5);
    -moz-transition: background .3s linear;
    -webkit-transition: background .3s linear;
    -o-transition: background .3s linear;
    transition: background .3s linear;
  }

  .button-card img {
    width: 100%;
    height: auto;
  }

  .button-card .btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
  }

  </style>

  <script>
    $('.owl-carousel').owlCarousel({
    loop:true,
    autoWidth:true,
    items:1
    });
  </script>
@endsection