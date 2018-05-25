@php $url = get_post_meta(get_the_ID(), 'upload_image', true) @endphp
<div class="card">
	<img class="card-img-top" src="{{ $url }}">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title</p>
    <a href="# class="btn btn-primary">Go somewhere</a>
  </div>
</div>