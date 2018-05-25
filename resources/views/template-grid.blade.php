{{--
  Template Name: Display Grid
--}}

@extends('layouts.app')

@section('content')
	@php $cpt = get_post_meta(get_the_ID(), 'selected_cpt', true) @endphp
  @php $query = new WP_Query( ['post_type' => $cpt] ); @endphp
  @include('partials.page-header')
  <div class="row">
  @while($query->have_posts()) @php $query->the_post() @endphp
    <div class="col-lg-4 col-md-4 col-sm-6">
    @include('partials.content-page-grid')
  	</div>
  @endwhile
	</div>
	<style>
	.card-img-top {
	  width: 100%;
	  height: 280px;
	  object-fit: cover;
	}
	.card {
	  height: 480px;
	  margin: 16px 0;
	}
	</style>
@endsection

