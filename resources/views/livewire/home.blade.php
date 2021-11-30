<div>
    <main>
        <!-- slider-area -->
        <section id="hero" class="slider slider-bg"
            data-background="{{ asset('assets/landing/img/slider/slider_01.jpg') }}">
            <div class="slider-active">
                <div class="single-slider">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-7">
                                <div class="slider__content third-c">
                                    <h2 data-animation="fadeInUp" data-delay=".2s">Clinic Appointment Reminders.</h2>
                                    <p data-animation="fadeInUp" data-delay=".4s">AfyaTime offers accurate and timely
                                        appointment reminders to patients who have regular clinic visits direct via SMS.
                                    </p>
                                    <div class="slider__content-btn" data-animation="fadeInUp" data-delay=".6s">
                                        <a href="#work" class="btn smoth-scroll">How It Work</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 d-none d-xl-block">
                                <div class="slider__img third-i" data-animation="fadeInRight" data-delay=".6s">
                                    <img src="{{ asset('assets/landing/img/slider/slider_img3.png') }}" alt="">
                                    <div class="slider-v">
                                        <a href="https://www.youtube.com/watch?v=vKSA_idPZkc"
                                            class="video-play popup-video"><i class="fas fa-play"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- slider-area-end -->
        <!-- features-area -->
        <section id="features" class="features-area pt-110 pb-115">
            <div class="features-shape d-none d-sm-block"
                data-background="{{ asset('assets/landing/img/bg/f_shape.png') }}"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1">
                        <div class="section__title text-center mb-75">
                            <span class="wow fadeInUp" data-wow-delay="0.2s">Features</span>
                            <h2 class="wow fadeInUp" data-wow-delay="0.4s">What is AfyaTime?</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.6s">Poor clinic attendance for medication top-up
                                or
                                investigations is a problem which leads to poor prognosis of most diseases. This is how
                                we
                                solve that.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="feature__nav">
                            <ul class="nav nav-tabs feature__nav-tab" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                        aria-controls="home" aria-selected="true"><i class="far fa-comments"></i>Manage
                                        Patients & Prescribers</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile"
                                        role="tab" aria-controls="profile" aria-selected="false"><i
                                            class="far fa-envelope"></i>SMS &
                                        Email Reminder</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                        aria-controls="contact" aria-selected="false"><i
                                            class="far fa-chart-bar"></i>Organization Analytics</a>
                                </li>
                            </ul>
                            <div class="tab-content feature__tab-content" id="myTabContent">
                                <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="single__features">
                                        <div class="row align-items-center">
                                            <div class="col-xl-6">
                                                <div class="single__features-img">
                                                    <img src="{{ asset('assets/landing/img/features/f_01.jpg') }}"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="single__features-content">
                                                    <div class="f-title">
                                                        <h2>Manage Patients & Prescribers</h2>
                                                        <p>Manage patients and prescribers in one platform. Ensuring
                                                            close
                                                            relationship and communication between prescribers and
                                                            patients
                                                            which establishes trust and responsibility towards clinic
                                                            attendance. Prescribers will ensure patients are aware of
                                                            their
                                                            appointment dates and set reminders which will be timely
                                                            sent to
                                                            the patients as SMS.</p>
                                                    </div>
                                                    <div class="inner__features">
                                                        <div class="icon">
                                                            <img src="{{ asset('assets/landing/img/icon/features_01.png') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="inner__features-content">
                                                            <h5>View Histoycal Data</h5>
                                                            <p>Track previous attendances and prescriber - patient
                                                                encounters</p>
                                                        </div>
                                                    </div>
                                                    <div class="inner__features">
                                                        <div class="icon">
                                                            <img src="{{ asset('assets/landing/img/icon/features_02.png') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="inner__features-content">
                                                            <h5>Review clinic performance</h5>
                                                            <p>Heve a clear picture of future clinic attendance
                                                                expectations
                                                                and establish resources capacity accordingly</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                    aria-labelledby="profile-tab">
                                    <div class="single__features">
                                        <div class="row align-items-center">
                                            <div class="col-xl-6">
                                                <div class="single__features-img wow fadeInLeft" data-wow-delay="0.2s">
                                                    <img src="{{ asset('assets/landing/img/features/f_02.jpg') }}"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="single__features-content">
                                                    <div class="f-title">
                                                        <h2>SMS & Email Reminder</h2>
                                                        <p>We have put together a complex reminder system that uses both
                                                            SMS
                                                            and E-mails to patients and prescribers respectifully
                                                            This enables clear and timely alerts which improves clinic
                                                            attendance and proper preparedness on the clinic side.
                                                        </p>
                                                    </div>
                                                    <div class="inner__features">
                                                        <div class="icon">
                                                            <img src="{{ asset('assets/landing/img/icon/features_01.png') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="inner__features-content">
                                                            <h5>SMS reminders</h5>
                                                            <p>Patients who have been subscribed to AfyaTime will
                                                                receice
                                                                multiple SMS in form of text messages to their phones
                                                                reminding them of their future appointment with further
                                                                information as required. The SMS will include the date,
                                                                time, clinic to attend and what to bring with them.</p>
                                                        </div>
                                                    </div>
                                                    <div class="inner__features">
                                                        <div class="icon">
                                                            <img src="{{ asset('assets/landing/img/icon/features_02.png') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="inner__features-content">
                                                            <h5>E-Mail reminders</h5>
                                                            <p>Clinics on the other hand will receive E-mails with
                                                                information about appointment dates. This includes
                                                                expected
                                                                attendees for the day, missed appointments, no show,
                                                                critical appointments and give prescribers alerts to
                                                                contact
                                                                patients in danger if missed frequent appointments. .
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="single__features">
                                        <div class="row align-items-center">
                                            <div class="col-xl-6">
                                                <div class="single__features-img">
                                                    <img src="{{ asset('assets/landing/img/features/f_03.jpg') }}"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="single__features-content">
                                                    <div class="f-title">
                                                        <h2>Organization Analytics</h2>
                                                        <p>Organizations and clinic service providers have a chance to
                                                            track
                                                            patients, prescribers, health service providers and also
                                                            plan in
                                                            advance how human and equipment resources are expected to be
                                                            for
                                                            future appointments. AfyaTime also allows tracking patient
                                                            attendance, enabling tracking less adherent patients and
                                                            contact
                                                            them.</p>
                                                    </div>
                                                    <div class="inner__features">
                                                        <div class="icon">
                                                            <img src="{{ asset('assets/landing/img/icon/features_01.png') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="inner__features-content">
                                                            <h5>Internal Analytics</h5>
                                                            <p>Ability to plan and deploy resources as needed since
                                                                future
                                                                attendance is known. Ability to space and maintain a
                                                                normal
                                                                defined number of attendances per day.</p>
                                                        </div>
                                                    </div>
                                                    <div class="inner__features">
                                                        <div class="icon">
                                                            <img src="{{ asset('assets/landing/img/icon/features_02.png') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="inner__features-content">
                                                            <h5>External Analytics</h5>
                                                            <p>Ability to track patients with poor attendance and
                                                                contact
                                                                them or send them regular high frequency SMS reminders.
                                                                Ability to give time specific appointment to avoid
                                                                unnecessary queues</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- features-area-end -->
        <!-- work-process-area -->
        <section id="work" class="work-process grey-bg pt-110 pb-85">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1">
                        <div class="section__title text-center mb-75">
                            <span class="wow fadeInUp" data-wow-delay="0.2s">Get AfyaTime</span>
                            <h2 class="wow fadeInUp" data-wow-delay="0.4s">How It Work?</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.6s">For secure and timely patient appointment
                                reminders sent via SMS AfyaTime is the solution that will ensure increase in clinic
                                attendance.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="single__process text-center mb-30 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="single__process-icon mb-40">
                                <img src="{{ asset('assets/landing/img/icon/work_01.png') }}" alt="">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="single__process-content">
                                <div class="number">01</div>
                                <h4>Pay for Organization Subscription</h4>
                                <p>Contact us and arrange to open your organization subscription account with AfyaTime.
                                    We
                                    have multiple subscription packages that suites all organization types.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single__process text-center mb-30 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="single__process-icon mb-40">
                                <img src="{{ asset('assets/landing/img/icon/work_02.png') }}" alt="">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="single__process-content">
                                <div class="number">02</div>
                                <h4>Register Patients and Health Provides</h4>
                                <p>Register your health providers who will be setting up patient and be able to set
                                    appointments and SMS reminders will be set in the system. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single__process text-center mb-30 wow fadeInUp" data-wow-delay="0.6s">
                            <div class="single__process-icon mb-40">
                                <img src="{{ asset('assets/landing/img/icon/work_03.png') }}" alt="">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="single__process-content">
                                <div class="number">03</div>
                                <h4>Appointment Reminders Ready</h4>
                                <p>Once appointment reminders have been registered in the system, patients will start to
                                    receive SMS reminders according to the dates and times set. Reminders can be sent a
                                    month, a week or a day before the appointment.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- work-process-area-end -->
        <!-- access-info-area -->
        <section id="whyafyatime" class="access-info access-sm pt-120 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="section__title access-title">
                            <h2>Get Access To All The Information You Need</h2>
                            <p>With AfyaTime platform all the information regarding patients attendance and clinic
                                situation
                                are at your finguretips. You will have clear analytics of patients and health providers
                                that
                                will enable you to prepare, plan and give help to clinic attendees as needed.</p>
                            <div class="access-btn">
                                <a href="#" class="btn">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="access__info-wrap mb-55">
                                    <div class="info-icon mb-35">
                                        <img src="{{ asset('assets/landing/img/icon/info_01.png') }}" alt="">
                                    </div>
                                    <div class="content">
                                        <h5>See who's slipping away</h5>
                                        <p>Track patients who frequent misses their appointments.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="access__info-wrap mb-55">
                                    <div class="info-icon mb-35">
                                        <img src="{{ asset('assets/landing/img/icon/info_01.png') }}" alt="">
                                    </div>
                                    <div class="content">
                                        <h5>Find out who needs help</h5>
                                        <p>Establish a clear picture of who need further follow up and further
                                            intervention
                                            as needed.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="access__info-wrap mb-55">
                                    <div class="info-icon mb-35">
                                        <img src="{{ asset('assets/landing/img/icon/info_01.png') }}" alt="">
                                    </div>
                                    <div class="content">
                                        <h5>Track clinic performance</h5>
                                        <p>Understand daily clinic needs, such as staffing requirements, equipment and
                                            supplies, medications, etc</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="access__info-wrap mb-55">
                                    <div class="info-icon mb-35">
                                        <img src="{{ asset('assets/landing/img/icon/info_01.png') }}" alt="">
                                    </div>
                                    <div class="content">
                                        <h5>Control clinic attendance</h5>
                                        <p>Have a control of number of attendees per day to avoid unecessary queues and
                                            improper use of resources.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- access-info-area-end -->
        <!-- cta-area -->
        <section id="download" class="cta-area cta-sm cta-bg pt-105"
            data-background="{{ asset('assets/landing/img/bg/cta_bg.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-xl-10 offset-xl-1 col-lg-10 offset-lg-1">
                        <div class="section__title cta-title text-center mb-20">
                            <h2 class="wow fadeInUp" data-wow-delay="0.2s">SMS Clinic Appointment Reminder Platform</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.4s">The first innovative digital solution to boost
                                clinic appointment attendance in Tanzania</p>
                            <div class="cta-btn">
                                <a href="#" class="btn wow fadeInUp" data-wow-delay="0.6s">Our Pricing</a>
                                <a href="#" class="btn wow fadeInUp" data-wow-delay="0.8s">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="cta__img text-center">
                            <img src="{{ asset('assets/landing/img/long-banner.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- cta-area-end -->

        <!-- contact-area -->
        <section id="contact-us" class="inner-blog grey-bg pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="blog-details-wrap">
                            <div class="post-comments-form mb-50">
                                <div class="comment__wrap-title">
                                    <h5>Contact Us</h5>
                                </div>
                                <div class="comment-box">

                                    <form autocomplete="off" wire:submit.prevent="contactUs" class="comment__form">
                                        @if ($errors->any())
                                        <ol>
                                            @foreach ($errors->all() as $error)
                                            <li><span> <i class="theme-color">{{ $error }}</i></span></li>
                                            @endforeach
                                        </ol>
                                        @endif
                                        @if ($sMessage)
                                        <span> <i class="theme-green">{{ $sMessage }}</i></span>
                                        @endif
                                        @if ($fMessage)
                                        <span> <i class="theme-color">{{ $fMessage }}</i></span>
                                        @endif
                                        <div class="comment-field mb-20">
                                            <i class="far fa-user"></i>
                                            <input wire:model.defer="state.name" id="name" name="name" type="text"
                                                placeholder="Type your name....">
                                        </div>

                                        <div class="comment-field mb-20">
                                            <i class="fas fa-envelope"></i>
                                            <input wire:model.defer="state.email" id="email" name="email" type="email"
                                                placeholder="Type your email....">
                                        </div>
                                        <div class="comment-field mb-20">
                                            <i class="fas fa-globe"></i>
                                            <input wire:model.defer="state.organization" id="organization"
                                                name="organization" type="text"
                                                placeholder="Type your organization....">
                                        </div>
                                        <div class="comment-field text-area mb-20">
                                            <i class="fas fa-pencil-alt"></i>
                                            <textarea wire:model.defer="state.message" id="message" name="message"
                                                cols="30" rows="10" placeholder="Type your message...."></textarea>
                                        </div>
                                        <button type="submit" class="btn">Send Message</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact-area-end -->
    </main>
</div>
