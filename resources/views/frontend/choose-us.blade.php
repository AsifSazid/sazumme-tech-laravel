<x-frontend.layouts.master>
    <x-frontend.layouts.partials.page-banner :pageTitle="'Why Choose Us'" />

    <x-frontend.sections.choose-us />

    <div class="section techwix-skill-section-02 section-padding"
        style="background-image: url({{ asset('ui/frontend/assets') }}/images/bg/skill-bg.jpg);">
        <div class="container">
            <div class="skill-wrap">
                <div class="row">
                    <div class="col-lg-6">
                        <!-- Skill Left Start -->
                        <div class="skill-left">
                            <div class="section-title">
                                <h2 class="title">Preparing for your success, we provide truly prominent IT solutions
                                </h2>
                            </div>
                            <div class="experience-wrap">
                                <div class="experience">
                                    <h2 class="number">10+</h2>
                                    <span>Projects <br> Delivered</span>
                                </div>
                                <div class="experience-text">
                                    <p>Accelerate innovation with world-class tech teams. At SazUmme, we connect you with exceptional freelance talent to meet all your software and digital infrastructure needs — from cloud, automation, and network solutions to IT strategy. We deeply understand your business goals and craft solutions that not only meet expectations but exceed them.</p>
                                    <a class="learn-more" href="{{ route('about-us') }}">learn More About Us <i
                                            class="fas fa-long-arrow-alt-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- Skill Left End -->
                    </div>
                    <div class="col-lg-6">
                        <!-- Skill Right Start -->
                        <div class="skill-right">
                            <div class="counter-bar">
                                <!-- Skill Item Start -->
                                <div class="skill-item">
                                    <span class="title">IT Managment</span>
                                    <div class="skill-bar">
                                        <div class="bar-inner">
                                            <div class="bar progress-line color-1" data-width="80" style="width: 80%;">
                                                <span class="skill-percent"><span class="counter">80</span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Skill Item End -->
                                <!-- Skill Item Start -->
                                <div class="skill-item">
                                    <span class="title">Data Security</span>
                                    <div class="skill-bar">
                                        <div class="bar-inner">
                                            <div class="bar progress-line color-1" data-width="95" style="width: 95%;">
                                                <span class="skill-percent"><span class="counter">95</span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Skill Item End -->
                                <!-- Skill Item Start -->
                                <div class="skill-item">
                                    <span class="title">Information Technology</span>
                                    <div class="skill-bar">
                                        <div class="bar-inner">
                                            <div class="bar progress-line color-1" data-width="80" style="width: 80%;">
                                                <span class="skill-percent"><span class="counter">80</span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Skill Item End -->
                                <!-- Skill Item Start -->
                                <div class="skill-item">
                                    <span class="title">Technology Consultant</span>
                                    <div class="skill-bar">
                                        <div class="bar-inner">
                                            <div class="bar progress-line color-1" data-width="90" style="width: 90%;">
                                                <span class="skill-percent"><span class="counter">90</span>%</span>
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

    <div class="section techwix-cta-section-04 techwix-cta-section-06 section-padding"
        style="background-image: url(assets/images/bg/cta-bg5.jpg);">
        <div class="container">
            <div class="cta-wrap">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <!-- Cta Left Start -->
                        <div class="cta-left">
                            <div class="section-title">
                                <h2 class="title white">To make requests for further information, contact us </h2>
                            </div>
                        </div>
                        <!-- Cta Left End -->
                    </div>
                    <div class="col-lg-5">
                        <!-- Cta Right Start -->
                        <div class="cta-info text-center">
                            <div class="cta-icon">
                                <img src="assets/images/cta-icon2.png" alt="">
                            </div>
                            <div class="cta-text">
                                <p>Call Us For Any inquiry</p>
                                <h3 class="number">+880 1684 576 384</h3>
                            </div>
                        </div>
                        <!-- Cta Right End -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-frontend.sections.welcome-section.testimonials />

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
