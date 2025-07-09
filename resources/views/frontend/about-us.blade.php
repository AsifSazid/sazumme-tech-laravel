<x-frontend.layouts.master>
    <!-- Page Banner Start -->
    <x-frontend.layouts.partials.page-banner :pageTitle="'About Us'" />
    <!-- Page Banner End -->

    <!-- About Start -->
    <div class="section techwix-about-section-07 section-padding">
        <div class="shape-1"></div>
        <div class="container">
            <!-- About Wrapper Start -->
            <div class="about-wrap">
                <div class="row">
                    <div class="col-lg-6">
                        <!-- About Image Wrap Start -->
                        <div class="about-img-wrap">
                            <img class="shape-1" src="{{ asset('ui/frontend/assets') }}/images/shape/about-shape2.png"
                                alt="">
                            <div class="about-img">
                                <img src="{{ asset('ui/frontend/assets') }}/images/about-big2-ai-300x453.png"
                                    alt="">
                            </div>
                            <div class="about-img about-img-2">
                                <img src="{{ asset('ui/frontend/assets') }}/images/about-4-ai-300x453.png"
                                    alt="">
                            </div>
                        </div>
                        <!-- About Image Wrap End -->
                    </div>
                    <div class="col-lg-6">
                        <!-- About Content Wrap Start -->
                        <div class="about-content-wrap">
                            <div class="section-title">
                                <h3 class="sub-title">Who we are</h3>
                                <h2 class="title">Empowering the Future through Innovation</h2>
                            </div>
                            <p class="text">SazUmme is a visionary ecosystem with 12 dynamic wings working across
                                technology, education, AI, agritech, branding, robotics, charity and more. Our mission
                                is to create innovative, impactful, and sustainable solutions that address real-world
                                challenges and empower communities.</p>
                            <!-- About List Start -->
                            <div class="about-list-03">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="about-list-item-03">
                                            <h3 class="title">Our Mission</h3>
                                            <p>To build a smart, inclusive and future-ready society through innovation,
                                                education and entrepreneurship.</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="about-list-item-03">
                                            <h3 class="title">Custom Code</h3>
                                            <p>We combine technology, human-centered design, and social good to create
                                                long-term value across industries.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- About List End -->
                        </div>
                        <!-- About Content Wrap End -->
                    </div>
                </div>
            </div>
            <!-- About Wrapper End -->
        </div>
    </div>
    <!-- About End -->

    <!-- Counter Start -->
    {{-- <div class="section techwix-counter-section-03 techwix-counter-section-04">
        <div class="container">
            <div class="counter-wrap"
                style="background-image: url({{ asset('ui/frontend/assets') }}/images/bg/counter-bg2.jpg);">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <!-- Single Counter Start -->
                        <div class="single-counter-02 text-center">
                            <span>354+</span>
                            <p>Completed Projects</p>
                        </div>
                        <!-- Single Counter End -->
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <!-- Single Counter Start -->
                        <div class="single-counter-02 text-center">
                            <span>119+</span>
                            <p>Robotic Automation</p>
                        </div>
                        <!-- Single Counter End -->
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <!-- Single Counter Start -->
                        <div class="single-counter-02 text-center">
                            <span>99%</span>
                            <p>Web Site Analyse</p>
                        </div>
                        <!-- Single Counter End -->
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <!-- Single Counter Start -->
                        <div class="single-counter-02 text-center">
                            <span>321+</span>
                            <p>Clients Supoort Done</p>
                        </div>
                        <!-- Single Counter End -->
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Counter End -->

    <!-- Choose Us Start -->
    <x-frontend.sections.choose-us />
    <!-- Choose Us End -->

    <!-- Skill Start -->
    <div class="section techwix-skill-section-02 techwix-skill-section-03 section-padding">
        <div class="container">
            <div class="skill-wrap">
                <div class="row">
                    <div class="col-lg-6">
                        <!-- Skill Left Start -->
                        <div class="skill-left">
                            <div class="section-title">
                                <h2 class="title">Our Capabilities at a Glance
                                </h2>
                            </div>
                            <div class="about-list">
                                <ul>
                                    <li>
                                        <span class="about-icon"><i class="fas fa-check"></i></span>
                                        <span class="about-text">Commitment to technical excellence </span>
                                    </li>
                                    <li>
                                        <span class="about-icon"><i class="fas fa-check"></i></span>
                                        <span class="about-text">Innovation-driven mindset across all projects</span>
                                    </li>
                                    <li>
                                        <span class="about-icon"><i class="fas fa-check"></i></span>
                                        <span class="about-text">Strategic partnership for long-term growth</span>
                                    </li>
                                </ul>
                            </div>
                            <!-- About Author Info Wrap Start -->
                            <div class="about-author-info-wrap">
                                <div class="about-author">
                                    <img src="{{ asset('ui/frontend/assets') }}/images/asif-sign.jpg" width="100" alt="Sign of Asif M. Sazid">
                                    <h3 class="name">Asif M. Sazid</h3>
                                    <span class="designation">CEO, SazUmme</span>
                                </div>
                                <div class="about-info">
                                    <p>Call to ask any question </p>
                                    <h3 class="number"><x-frontend.layouts.partials.phone-no /></h3>
                                </div>
                            </div>
                            <!-- About Author Info Wrap End -->
                        </div>
                        <!-- Skill Left End -->
                    </div>
                    <div class="col-lg-6">
                        <!-- Skill Right Start -->
                        <div class="skill-right">
                            <p class="text">Accelerate innovation with world-class tech teams. At SazUmme, we connect you with exceptional freelance talent to meet all your software and digital infrastructure needs — from cloud, automation, and network solutions to IT strategy. We deeply understand your business goals and craft solutions that not only meet expectations but exceed them.</p>
                            <div class="counter-bar">
                                <!-- Skill Item Start -->
                                <div class="skill-item">
                                    <span class="title">IT Consultancy</span>
                                    <div class="skill-bar">
                                        <div class="bar-inner">
                                            <div class="bar progress-line color-1" data-width="80">
                                                <span class="skill-percent"><span class="counter">80</span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Skill Item End -->
                                <!-- Skill Item Start -->
                                <div class="skill-item">
                                    <span class="title">Web Design and Development</span>
                                    <div class="skill-bar">
                                        <div class="bar-inner">
                                            <div class="bar progress-line color-1" data-width="95">
                                                <span class="skill-percent"><span class="counter">95</span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Skill Item End -->
                                <!-- Skill Item Start -->
                                <div class="skill-item">
                                    <span class="title">AI and Automation</span>
                                    <div class="skill-bar">
                                        <div class="bar-inner">
                                            <div class="bar progress-line color-1" data-width="70">
                                                <span class="skill-percent"><span class="counter">70</span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Skill Item End -->
                            </div>
                        </div>
                        <!-- Skill Right End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Skill End -->

    <!-- Team Start -->
    {{-- <x-frontend.sections.welcome-section.team /> --}}
    <!-- Team End -->

    <!-- Testimonial Start  -->
    {{-- <x-frontend.sections.welcome-section.testimonials /> --}}
    <!-- Testimonial End  -->

    <!-- Cta Start -->
    <x-frontend.layouts.partials.cta />
    <!-- Cta End -->

    @push('css')
        <style>
            .choose-us-img .icon {
                color: #89c4e6;
                /* soft blue */
                font-size: 40px;
                flex-shrink: 0;
                margin-top: 4px;
            }
        </style>
    @endpush
</x-frontend.layouts.master>
