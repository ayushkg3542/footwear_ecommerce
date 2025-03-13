	<!-- Start Header Area -->
	<header class="header_area sticky-header">
	    <div class="main_menu">
	        <nav class="navbar navbar-expand-lg navbar-light main_box">
	            <div class="container">
	                <!-- Brand and toggle get grouped for better mobile display -->
	                <a class="navbar-brand logo_h" href="{{ route('home') }}"><img
	                        src="{{url('public/front/img/logo.png')}}" alt=""></a>
	                <button class="navbar-toggler" type="button" data-toggle="collapse"
	                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
	                    aria-label="Toggle navigation">
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                </button>
	                <!-- Collect the nav links, forms, and other content for toggling -->
	                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
	                    <ul class="nav navbar-nav menu_nav ml-auto">
	                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
	                        <li class="nav-item"><a href="{{ route('products') }}" class="nav-link">Shop</a></li>
	                        <li class="nav-item"><a href="#" class="nav-link">Blog</a></li>
	                        <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>

	                        <li class="nav-item submenu dropdown">
	                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
	                                aria-haspopup="true" aria-expanded="false"><i class="bi bi-person-circle"
	                                    style="font-size: 14px"></i>
	                                @auth
	                                {{ auth()->user()->name }}
	                                @else
	                                Account
	                                @endauth
	                            </a>
	                            <ul class="dropdown-menu">
	                                <li class="nav-item"><a class="nav-link" href="{{ route('wishlist') }}">Wishlist</a>
	                                </li>
	                                @guest
	                                <li class="nav-item"><a class="nav-link" href="{{ route('account.login') }}">Login</a>
	                                </li>
	                                <li class="nav-item"><a class="nav-link"
	                                        href="{{ route('account.register') }}">Register</a></li>
	                                @else
	                                <li class="nav-item"><a class="nav-link"
	                                        href="{{ route('account.logout') }}">Logout</a></li>
	                                @endguest
	                                <!-- <li class="nav-item"><a class="nav-link" href="elements.html">Elements</a></li> -->
	                            </ul>
	                        </li>

	                    </ul>
	                    <ul class="nav navbar-nav navbar-right">
	                        <li class="nav-item"><a href="{{ route('cart') }}" class="cart"><span class="ti-bag"></span>

	                                @if(session('cart_count')>0)
	                                <span class="cart-count text-light bg-danger">{{ session('cart_count') }}</span>
	                                @endif
	                            </a></li>
	                        <li class="nav-item">
	                            <button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
	                        </li>

	                    </ul>
	                </div>
	            </div>
	        </nav>
	    </div>
	    <div class="search_input" id="search_input_box">
	        <div class="container">
	            <form class="d-flex justify-content-between" id="searchForm">
	                <input type="text" class="form-control" id="search_input" name="search" placeholder="Search Here">
	                <button type="submit" class="btn"></button>
	                <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
	            </form>
	        </div>
	    </div>
	</header>
	<!-- End Header Area -->

	<!--  -->