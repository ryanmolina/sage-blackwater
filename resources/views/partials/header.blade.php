<header class="banner">
  <div class="container">
    <div class="row">
      <a class="site-brand col-lg-6" href="{{ home_url('/') }}"><img src="{{ App::logo() }}"></a>

      <div class="site-meta col-lg-6">
        <ul class="social-icons">
          <li><img src="https://www.blackwatercottagebandb.co.uk/wp-content/themes/slate/images/social-icon-twitter.png"></li>
          <li><img src="https://www.blackwatercottagebandb.co.uk/wp-content/themes/slate/images/social-icon-facebook.png"></li>
          <li><img src="https://www.blackwatercottagebandb.co.uk/wp-content/themes/slate/images/social-icon-tripadvisor.png"></li>
        </ul>

        <div class="site-contact">
          <address class="site-address">
            <span><i class="fa fa-address-card"></i></span>
            "Blackwater Cottage, Blackwater, Somerset, TA20 3LE"
          </address>
          <div class="site-phone">
            <span><i class="fa fa-phone"></i></span>
            "01460 234228"
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
<style>
.nav-primary {
  font-size: 87%;
  border-bottom: 1px solid #4a4a4a;
  padding: 0;
  margin-bottom: 16px;
  width: 100%;
}

.nav-primary > .nav > li {
  display: inline-block;
}
.nav-primary > .nav > li:first-child {
  border-top-left-radius: 20px;
  border-bottom-left-radius: 20px;
}
.nav-primary > .nav > li:last-child {
  border-top-right-radius: 20px;
  border-bottom-right-radius: 20px;
}
.nav-primary .nav > li:hover {
  background: #f5f5f5;
}
.nav-primary .nav .sub-menu > li:hover {
  background: white;
}
.nav-primary .menu-item a {
  color: black;
  display: block;
  padding: 8px 10px 8px 10px;
  text-transform: uppercase;
  text-decoration: none;
  letter-spacing: .15em;
  transition-duration: .3s;
  text-shadow: 1px 1px 1px rgba(255,255,255,.6);
}

.nav-primary .menu-item:first-child a {
  padding-left: 0;
}

.nav-primary .sub-menu {
  /*style all lists below the top-level list*/
  background: #f5f5f5;
  border: 1px solid #ccc;
  border-bottom-left-radius: 8px;
  border-bottom-right-radius: 8px;
  border-top: none;
  padding: 20px 0;
  position: absolute;
  min-width: 140px;
  z-index: 10;
  visibility: hidden;
}
.nav-primary .nav .sub-menu li {
  position: relative;
}
.nav-primary .nav .sub-menu ul {
  /*style all lists below the second-level list*/
  border: 1px solid #ccc;
  border-right: none;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
  padding: 0;
  left: -100%;
  top: -1px;
}
.nav-primary li:hover > ul {
  /*show the menu of the list item being hovered over*/
  visibility: visible;
}
</style>
