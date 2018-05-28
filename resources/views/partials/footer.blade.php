<footer class="footer">
  <div class="container">
    <div class="row">
      <ul class="social-icons">
        @php
        $social_icons = json_decode(get_theme_mod('theme_footer_social-icons'));
        @endphp
        @foreach($social_icons as $icon)
          <li><a href="{{ $icon->href }}"><img src="{{ $icon->image_url }}"></a></li>
        @endforeach
      </ul>
    </div>
  	<div class="row footer-content">
      <div class="col-md-6" id="footer-copyright">
        &copy; Copyright Blackwater Cottage 2013
      </div>
      <div class="col-md-6 footer-menu">
        <a href="#">Terms & Conditions</a>
      </div>
	  </div>
  </div>
</footer>
