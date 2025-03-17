<x-frontend.layouts.master>
    <!-- Offcanvas Start-->
    <div class="offcanvas offcanvas-start" id="offcanvasExample">
        <div class="offcanvas-header">
            <!-- Offcanvas Logo Start -->
            <div class="offcanvas-logo">
                <a href="index.html"><img src="{{ asset('ui/frontend/assets') }}/images/logo-white.png" alt=""></a>
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
                        <ul class="sub-menu">
                            <li class="active"><a href="index.html">Home Main</a></li>
                            <li><a href="index-2.html">AI Solutions</a></li>
                            <li><a href="index-3.html">Cyber Security</a></li>
                            <li><a href="index-4.html">IT Solutions</a></li>
                            <li><a href="index-5.html">Software Company</a></li>
                            <li><a href="index-6.html">IT Agency</a></li>
                        </ul>
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
    <!-- Offcanvas End -->


    <!-- Hero Start -->
        <x-frontend.sections.welcome-section.hero-area />
        <!-- Hero End -->
        
    <!-- Service Start -->
        <x-frontend.sections.welcome-section.service />
    <!-- Service End -->

    <!-- About Start -->
        <x-frontend.sections.welcome-section.about />
    <!-- About End -->

    <!-- Counter Start -->
        <x-frontend.sections.welcome-section.counter />
    <!-- Counter End -->

    <!-- Choose Us Start -->
        <x-frontend.sections.welcome-section.choose-us />
    <!-- Choose Us End -->

    <!-- Skill Start -->
        <x-frontend.sections.welcome-section.skill />
    <!-- Skill End -->

    <!-- Case Study Start -->
        <x-frontend.sections.welcome-section.case-study />
    <!-- Case Study End -->

    <!-- Testimonial Start  -->
        <x-frontend.sections.welcome-section.testimonials />
    <!-- Testimonial End  -->

    <!-- Brand Logo Start -->
        <x-frontend.sections.welcome-section.brand-logos />
    <!-- Brand Logo End -->

    <!-- Team Start -->
        <x-frontend.sections.welcome-section.team />
    <!-- Team End -->

    <!-- Blog Start -->
        <x-frontend.sections.welcome-section.blog />
    <!-- Blog End -->

    <!-- Cta Start -->
        <x-frontend.layouts.partials.cta />
    <!-- Cta End -->
</x-frontend.layouts.master>
