<header class="banner">
  <div class="container">
    <div class="row">
      <a class="site-brand col-lg-6" href="{{ home_url('/') }}"><img src="{{ App::logo() }}"></a>

      <div class="site-meta col-lg-6">
        <ul class="social-icons">
          @php
          $social_icons = json_decode(get_theme_mod('theme_header_social-icons'));
          @endphp
          @foreach($social_icons as $icon)
            <li><a href="{{ $icon->href }}"><img src="{{ $icon->image_url }}"></a></li>
          @endforeach
        </ul>

        <div class="site-contact">
          <address class="site-address">
            <span><i class="fa fa-address-card"></i></span>
            {{ get_theme_mod('theme_header_address') }}
          </address>
          <div class="site-phone">
            <span><i class="fa fa-phone"></i></span>
            {{ get_theme_mod('theme_header_phone')}}
          </div>
        </div>

      </div>
    </div>
    <div class="row">
      <nav class="nav-primary">
        @if (has_nav_menu('primary_navigation'))
          {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'depth' => 2,]) !!}
        @endif
      </nav>
    </div>
  </div>
</header>
