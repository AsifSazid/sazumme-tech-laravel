<x-frontend.layouts.master>
    <x-frontend.layouts.partials.page-banner :pageTitle="'Contact Us'" />

    <div class="section contact-info-section section-padding-02">
        <div class="container">
            <!-- Contact Info Wrap Start -->
            <div class="contact-info-wrap">
                <div class="row">
                    <div class="col-lg-4 col-sm-6">
                        <!--Single Contact Info Start -->
                        <div class="single-contact-info text-center">
                            <div class="info-icon">
                                <img src="{{ asset('ui/frontend/assets') }}/images/info-1.png" alt="">
                            </div>
                            <div class="info-content">
                                <h5 class="title">Give us a call</h5>
                                <p>(+880) 1684 576 384</p>
                                <p>(+880) 1751 906 710</p>
                            </div>
                        </div>
                        <!--Single Contact Info End -->
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <!--Single Contact Info Start -->
                        <div class="single-contact-info text-center">
                            <div class="info-icon">
                                <img src="{{ asset('ui/frontend/assets') }}/images/info-2.png" alt="">
                            </div>
                            <div class="info-content">
                                <h5 class="title">Drop us a line</h5>
                                <p>info@sazumme.com</p>
                                <p>asif83sazid@gmail.com</p>
                            </div>
                        </div>
                        <!--Single Contact Info End -->
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <!--Single Contact Info Start -->
                        <div class="single-contact-info text-center">
                            <div class="info-icon">
                                <img src="{{ asset('ui/frontend/assets') }}/images/info-3.png" alt="">
                            </div>
                            <div class="info-content">
                                <h5 class="title">Visit our office</h5>
                                <p>Kanchkura, Uttarkhan, Dhaka-1230</p>
                            </div>
                        </div>
                        <!--Single Contact Info End -->
                    </div>
                </div>
            </div>
            <!-- Contact Info Wrap End -->
        </div>
    </div>

    <div class="section techwix-contact-section techwix-contact-section-02 techwix-contact-section-03 section-padding-02">
        <div class="container">
            <!-- Contact Wrap Start -->
            <div class="contact-wrap">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                    <!-- Contact Form Start -->
                    <div class="contact-form">
                        <div class="contact-form-wrap">
                            <div class="heading-wrap text-center">
                                <span class="sub-title">Request a quote</span>
                                <h3 class="title">How May We Help You!</h3>
                            </div>
                            <form action="https://thepixelcurve.com/html/techwix/techwix/submit.php" method="POST">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- Single Form Start -->
                                        <div class="single-form">
                                            <input type="text" name="name" placeholder="Name *" required="">
                                        </div>
                                        <!-- Single Form End -->
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- Single Form Start -->
                                        <div class="single-form">
                                            <input type="email" name="email" placeholder="Email *" required="">
                                        </div>
                                        <!-- Single Form End -->
                                    </div>
                                    <div class="col-sm-12">
                                        <!-- Single Form Start -->
                                        <div class="single-form">
                                            <input type="text" name="subject" placeholder="Subject *" required="">
                                        </div>
                                        <!-- Single Form End -->
                                    </div>
                                    <div class="col-sm-12">
                                        <!-- Single Form Start -->
                                        <div class="single-form">
                                            <textarea name="message" placeholder="Write A Message" rows="5" required=""></textarea>
                                        </div>
                                        <!-- Single Form End -->
                                    </div>
                                    <div class="col-sm-12">
                                        <!-- Single Form Start -->
                                        <div class="form-btn">
                                            <button class="btn" type="submit">Send Message</button>
                                        </div>
                                        <!-- Single Form End -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Contact Form End -->
                    </div>
                </div>
            </div>
            <!-- Contact Wrap End -->
        </div>
    </div>

    <div class="section contact-map-section">
        <div class="contact-map-wrap">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14594.005624537545!2d90.44460283775643!3d23.871832530988854!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755cf53c3bba56f%3A0xd366f7665314a0a4!2sKachkura%20Bus%20Stop!5e0!3m2!1sen!2sbd!4v1744055779704!5m2!1sen!2sbd" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>        </div>
    </div>
</x-frontend.layouts.master>