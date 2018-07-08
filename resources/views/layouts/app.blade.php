<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:400,600,700%7CLato:400,700' type='text/css' media='all' />
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kwits') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/justifiedGallery.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/magnific-popup.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
    @yield('styles')
    <style media="screen">
      a.bitcoin {
        color: #000000 !important;
      }
      [v-cloak] { display: none; }
    </style>
</head>
<body class="home menu-left">
    <div id="app">
        <!-- Preload -->
    		<div id="preload">
    			<div class="kd-bounce">
    				<div></div>
    				<div></div>
    			</div>
    		</div>
    		<!-- Preload -->

        <!-- Mobile Menu -->
    		<div class="mobile">
    			<div class="container">
    				<!-- Mobile -->
    				<div class="menu-mobile">
    					<span class="item item-1"></span>
    					<span class="item item-2"></span>
    					<span class="item item-3"></span>
    				</div>
    				<!-- End Mobile -->

    				<!-- Logo -->
    				<div class="logo">
    					<a href="index-2.html">Kwits</a>
    				</div>
    				<!-- End Logo -->
    			</div>
    		</div>
    		<div class="hide-menu"></div>
    		<!-- End Mobile Menu -->

        <div class="container">
          <div class="row">
            <div class="col-md-3 col-md-push-9">
    					<div class="header affix">
    						<div class="table">
    							<div class="table-cell">
    								<!-- Logo -->
    								<div class="logo">
    									<a href="index-2.html">Kwits</a>
    								</div>
    								<!-- End Logo -->

    								<!-- Navigation -->
    								<div class="main-menu">
    									<nav>
    										<ul class="menu-list">
    											<li class="{{ Request::is('home') ? 'active' : '' }} menu-item-has-children">
    												<a href="/home">Home</a>
    											</li>
    											<li class="{{ Request::is('dashboard') ? 'active' : '' }}">
    												<a href="/dashboard">Dashboard</a>
    											</li>
    											<li class="{{ Request::is('travels') ? 'active' : '' }}">
    												<a href="/travels">Travels</a>
    											</li>
                          <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                               Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                          </li>
    										</ul>
    									</nav>
    								</div>
    								<!-- End Navigation -->

    								<!-- Socials -->
    								<div class="socials">
    									<a href="#" title="Behance">
    										<i class="fa fa-behance"></i>
    									</a>
    									<a href="#" title="Dribbble">
    										<i class="fa fa-dribbble"></i>
    									</a>
    									<a href="#" title="Facebook">
    										<i class="fa fa-facebook"></i>
    									</a>
    									<a href="#" title="Google Plus">
    										<i class="fa fa-google-plus"></i>
    									</a>
    									<a href="#" title="Instagram">
    										<i class="fa fa-instagram"></i>
    									</a>
                      @if(! auth()->guest() && Request::is('dashboard'))
                        @if( ! $user->access_token)
                          <a class="bitcoin" href="{{ config('coins.auth') }}" title="Bitcoin">
                            <i class="fa fa-bitcoin"></i>
                          </a>
                        @endif
                      @endif
    									<a href="#" title="Search this site">
    										<i class="fa fa-plus"></i>
    									</a>
    								</div>
                    @if(isset($members))
                    <div class="box-search">
                      <div class="table">
                        <div class="table-cell">
                          <div class="container">
                            @include("travels.splits.options", ["members" => $members])
                          </div>
                        </div>
                      </div>
                    </div>
                    @endif
    								<!-- End Socials -->

    								<div class="copyright">
    									<p>
    										Kwits @ 2018. Design by Kwits
    									</p>
    								</div>

    							</div>
    						</div>
    					</div>
    				</div>
            @yield('content')
          </div>
        </div>



        <flash message="{!! session('flash') !!}"></flash>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/libs/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
	  <script src="{{ asset('js/libs/jquery.justifiedGallery.min.js') }}"></script>
	  <script src="{{ asset('js/libs/jquery.magnific-popup.js') }}"></script>
	  <script src="{{ asset('js/scripts.js') }}"></script>
    @yield('scripts')
</body>
</html>
