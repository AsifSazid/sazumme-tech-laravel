<div id="header" class="section header-section">

    <div class="container">

        <!-- Header Wrap Start  -->
        <div class="header-wrap">

            <div class="header-logo">
                <a href="{{ route('welcome') }}">
                    <img src="{{ asset('ui/frontend/assets') }}/images/logos/full-logo.png" alt="">
                </a>
            </div>

            <div class="header-menu d-none d-lg-block">
                <ul class="main-menu">
                    <li class="active-menu">
                        <a href="{{ route('welcome') }}">Home</a>
                    </li>
                    <li><a href="#">About</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('about-us') }}">Aboute Us</a></li>
                            <li><a href="{{ route('choose-us') }}">Why Choose Us</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('our-wings') }}">Our Wings</a>
                    </li>
                    <li><a href="{{ route('our-team') }}">Our Team</a></li>
                    {{-- <li><a href="#">Blog</a>
                        <ul class="sub-menu">
                            <li><a href="blog.html">Blog Grid</a></li>
                            <li><a href="blog-standard.html">Blog List</a></li>
                            <li><a href="blog-details.html">Blog Single</a></li>
                        </ul>
                    </li> --}}
                    <li><a href="{{ route('contact-us') }}">Contact</a></li>
                </ul>
            </div>

            <!-- Header Meta Start -->
            <div class="header-meta">
                <!-- Header Cart Start -->
                {{-- <div class="header-cart dropdown">
                    <button class="cart-btn" data-bs-toggle="dropdown">
                        <i class="flaticon-shopping-cart"></i>
                        <span class="count">0</span>
                    </button>
                    <!-- Header Dropdown Cart Start -->
                    <div class="dropdown-menu dropdown-cart">
                        <!-- Dropdown Cart Items Start -->
                        <div class="cart-items">
                            <!-- Single Cart Item Start -->
                            <div class="single-cart-item">
                                <div class="item-image">
                                    <img src="{{ asset('ui/frontend/assets') }}/images/shop-cart-1.jpg"
                                        alt="cart">
                                </div>
                                <div class="item-content">
                                    <h4 class="title"><a href="#">Apple Iphone X</a></h4>
                                    <span class="quantity">2 x $59.99</span>
                                </div>
                                <button class="btn-close"></button>
                            </div>
                            <!-- Single Cart Item End -->
                            <!-- Single Cart Item Start -->
                            <div class="single-cart-item">
                                <div class="item-image">
                                    <img src="{{ asset('ui/frontend/assets') }}/images/shop-cart-2.jpg"
                                        alt="cart">
                                </div>
                                <div class="item-content">
                                    <h4 class="title"><a href="#">Sony Xperia Tablet</a></h4>
                                    <span class="quantity">2 x $59.99</span>
                                </div>
                                <button class="btn-close"></button>
                            </div>
                            <!-- Single Cart Item End -->
                            <!-- Single Cart Item Start -->
                            <div class="single-cart-item">
                                <div class="item-image">
                                    <img src="{{ asset('ui/frontend/assets') }}/images/shop-cart-3.jpg"
                                        alt="cart">
                                </div>
                                <div class="item-content">
                                    <h4 class="title"><a href="#">Camera Digital</a></h4>
                                    <span class="quantity">2 x $59.99</span>
                                </div>
                                <button class="btn-close"></button>
                            </div>
                            <!-- Single Cart Item End -->
                        </div>
                        <!-- Dropdown Cart Items End -->
                        <!-- Dropdown Cart Total Start -->
                        <div class="cart-total">
                            <span class="label">Subtotal:</span>
                            <span class="value">0</span>
                        </div>
                        <!-- Dropdown Cart Total End -->
                        <!-- Dropdown Cart Button Start -->
                        <div class="cart-btns">
                            <a class="btn" href="#">View Cart</a>
                            <a class="btn btn-2" href="#">Checkout</a>
                        </div>
                        <!-- Dropdown Cart Button End -->
                    </div>
                    <!-- Header Dropdown Cart End -->
                </div> --}}
                <!-- Header Cart End -->
                <!-- Header Search Start -->
                <div class="header-search">
                    <a class="search-btn" href="#"><i class="flaticon-loupe"></i></a>
                    <div class="search-wrap">
                        <div class="search-inner">
                            <i id="search-close" class="flaticon-close search-close"></i>
                            <div class="search-cell">
                                <form action="#">
                                    <div class="search-field-holder">
                                        <input class="main-search-input" type="search"
                                            placeholder="Search Your Keyword...">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Header Search End -->

                <div class="header-btn d-none d-xl-block">
                    <a class="btn" href="{{ route('login') }}">Get Started</a>
                </div>
                <!-- Header Toggle Start -->
                <div class="header-toggle d-lg-none">
                    <button data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
                <!-- Header Toggle End -->
            </div>
            <!-- Header Meta End  -->

        </div>
        <!-- Header Wrap End  -->

    </div>
</div>

<div class="offcanvas offcanvas-start" id="offcanvasExample">
    <div class="offcanvas-header">
        <!-- Offcanvas Logo Start -->
        <div class="offcanvas-logo">
            <a href="index.html"><img src="{{ asset('ui/frontend/assets') }}/images/logos/full-logo.png"
                    alt=""></a>
        </div>
        <!-- Offcanvas Logo End -->
        <button type="button" class="close-btn" data-bs-dismiss="offcanvas"><i class="flaticon-close"></i></button>
    </div>

    <!-- Offcanvas Body Start -->
    <div class="offcanvas-body">
        <div class="offcanvas-menu">
            <ul class="main-menu">
                <li class="active-menu">
                    <a href="index.html">Home</a>
                </li>
                <li>
                    <a href="about.html">Aboute Us</a>
                </li>
                <li><a href="#">Pages</a>
                    <ul class="sub-menu">
                        <li><a href="team.html">Our Team</a></li>
                        <li><a href="service.html">Service</a></li>
                        <li><a href="choose-us.html">Why Choose Us</a></li>
                        <li><a href="testimonial.html">Testimonial</a></li>
                        <li><a href="pricing.html">Pricing</a></li>
                        <li><a href="login-register.html">Login & Register</a></li>
                    </ul>
                </li>
                <li><a href="#">Blog</a>
                    <ul class="sub-menu">
                        <li><a href="blog.html">Blog Grid</a></li>
                        <li><a href="blog-standard.html">Blog List</a></li>
                        <li><a href="blog-details.html">Blog Single</a></li>
                    </ul>
                </li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </div>
    </div>
    <!-- Offcanvas Body End -->
</div>
