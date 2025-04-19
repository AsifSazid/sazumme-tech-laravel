<div class="section techwix-service-section-03"
    style="background-image: url({{ asset('ui/frontend/assets') }}/images/bg/service-bg3.jpg);">
    <div class="container">
        <!-- Service Wrap Start -->
        <div class="service-wrap-03">
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <!-- Service Item Start -->
                    <div class="service-item-03">
                        <div class="service-img">
                            {{-- <img src="{{ asset('ui/frontend/assets') }}/images/ser-icon9.png" alt=""> --}}
                            <i class="fas fa-code icon"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="title">SazTech<br><span class="sub">Software Firm</span></h3>
                            <p>Building modern web application that scales with your vision.</p>
                            <div class="read-more">
                                <a href="#"><i class="fas fa-plus"></i> Read More</a>
                            </div>
                        </div>
                    </div>
                    <!-- Service Item End -->
                </div>
                <div class="col-xl-3 col-md-6">
                    <!-- Service Item Start -->
                    <div class="service-item-03">
                        <div class="service-img">
                            <i class="fas fa-graduation-cap icon"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="title">SazEdify<br><span class="sub">Edutech</span></h3>
                            <p>Empowering learners with next-gen educational tools.</p>
                            <div class="read-more">
                                <a href="#"><i class="fas fa-plus"></i> Read More</a>
                            </div>
                        </div>
                    </div>
                    <!-- Service Item End -->
                </div>
                <div class="col-xl-3 col-md-6">
                    <!-- Service Item Start -->
                    <div class="service-item-03">
                        <div class="service-img">
                            <i class="fas fa-book-open icon"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="title">SazVerse<br><span class="sub">Publication</span></h3>
                            <p>Publishing voices, ideas, and impact-driven stories.</p>
                            <div class="read-more">
                                <a href="{{route('publication.about-us')}}"><i class="fas fa-plus"></i> Read More</a>
                            </div>
                        </div>
                    </div>
                    <!-- Service Item End -->
                </div>
                <div class="col-xl-3 col-md-6">
                    <!-- Service Item Start -->
                    <div class="service-item-03">
                        <div class="service-img">
                            <i class="fas fa-heart icon"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="title">SazHope<br><span class="sub">Charity</span></h3>
                            <p>Lighting lives with hope and <br> heart.</p>
                            <div class="read-more">
                                <a href="#"><i class="fas fa-plus"></i> Read More</a>
                            </div>
                        </div>
                    </div>
                    <!-- Service Item End -->
                </div>
            </div>
        </div>
        <!-- Service Wrap End -->
    </div>
</div>

@push('css')
    <style>
        .service-img .icon {
            color: #89c4e6;
            /* soft blue */
            font-size: 40px;
            flex-shrink: 0;
            margin-top: 4px;
        }
    </style>
@endpush
