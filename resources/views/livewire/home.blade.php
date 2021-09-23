<div>
    <main class="main-content">
        <div class="app-loader"><i class="icofont-spinner-alt-4 rotate"></i></div>

        <div class="main-content-wrap mb-5">

            <div class="page-content">
                <div class="card bg-light bg-gradient">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8 mb-4 mb-md-0">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="169" height="40">
                                </a>
                                <h3 class="">AfyaTime App</h3>
                                <p class="text-muted">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus id perferendis
                                    unde voluptas
                                    voluptatem? Ad alias deleniti eum nulla tempore.
                                </p>
                            </div>

                            <div class="col-12 col-md-4 text-right">
                                {{-- <h4 class="text-primary mt-0 mb-1"></h4>
                                <p class="mb-0 text-muted">Income in current month</p> --}}
                                <div class="chat-container container-h-50 mt-5">
                                    <a href="{{ route('login') }}" type="button" class="btn btn-success btn-block">
                                        <h6> Login </h6>
                                    </a>
                                </div>
                                <div class="chat-container container-h-50 mt-2">
                                    <a href="{{ route('home', ['action' => 'contact-us']) }}" type="button"
                                        class="btn btn-primary btn-block">
                                        <h6> Contact Us </h6>
                                    </a>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                @if ($action == null)
                <div>
                    <div class="row">
                        <div class="col-12 col-md-12 mb-5">
                            <h2 class="text-center">Packages</h2>
                            <p class="text-muted mb-4 text-center">Lorem ipsum dolor sit amet, consectetur adipisicing
                                elit.
                                Ab, dolorem
                                excepturi
                                facilis magni necessitatibus
                                perspiciatis repellendus sunt veniam? A ad architecto aspernatur cupiditate dignissimos
                                distinctio earum,
                                eligendi eum
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="card text-center mb-md-0 bg-light">
                                <div class="card-header">
                                    Starter
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="fs-48 mr-2">39</div>
                                        <div class="text-muted">
                                            <div class="fs-20">USD</div>
                                            <div>month</div>
                                        </div>
                                    </div>

                                    <hr class="mt-4 mb-4">

                                    <ul class="list-unstyled text-left">
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">150 Appointments/Month</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">Free Email Reminders</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">1 Reminder per Appointment</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">2 Staff Logins</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-close-circled text-muted"></div>
                                            <span class="ml-1">More Features</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">Free Support</span>
                                        </li>
                                    </ul>

                                    <a href="{{ route('home', ['action' => 'sign-up', 'package' => 'starter']) }}"
                                        class="btn btn-success btn-block mb-3">Select Plan</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="card text-center mb-md-0 bg-light">
                                <div class="card-header">
                                    Business
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="fs-48 mr-2 text-primary">59</div>
                                        <div class="text-muted">
                                            <div class="fs-20">USD</div>
                                            <div>month</div>
                                        </div>
                                    </div>

                                    <hr class="mt-4 mb-4">

                                    <ul class="list-unstyled text-left">
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">250 appointments/Month</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">Free Email Reminders</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">2 Reminder per Appointment</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">10 Staff Logins</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">More Features</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">Free Support</span>
                                        </li>
                                    </ul>

                                    <a href="{{ route('home', ['action' => 'sign-up', 'package' => 'business']) }}"
                                        class="btn btn-primary btn-block mb-3">Select Plan</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="card text-center bg-light mb-0">
                                <div class="card-header">
                                    Premium
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="fs-48 mr-2">99</div>
                                        <div class="text-muted">
                                            <div class="fs-20">USD</div>
                                            <div>month</div>
                                        </div>
                                    </div>

                                    <hr class="mt-4 mb-4">

                                    <ul class="list-unstyled text-left">
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">500 Appointments/Month</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">Free Email Reminders</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">3 Reminder per Appointment</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">Unlimited Staff Logins</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">Early Access to New Features</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">Message Blasts</span>
                                        </li>
                                        <li class="d-flex align-items-center pt-2 pb-2">
                                            <div class="icon icofont-check-circled text-muted"></div>
                                            <span class="ml-1">Free Support</span>
                                        </li>
                                    </ul>

                                    <a href="{{ route('home', ['action' => 'sign-up', 'package' => 'premium']) }}"
                                        class="btn btn-success btn-block mb-3">Select Plan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if ($action == 'contact-us')
                <div>
                    <div class="row">
                        <div class="col-12 col-md-12 mb-5">
                            <h2 class="text-center">Contact Us</h2>
                            <p class="text-muted mb-4 text-center">Lorem ipsum dolor sit amet, consectetur adipisicing
                                elit.
                                Ab, dolorem
                                excepturi
                                facilis magni necessitatibus
                                perspiciatis repellendus sunt veniam? A ad architecto aspernatur cupiditate dignissimos
                                distinctio earum,
                                eligendi eum
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-12 col-md-6 mb-md-0">
                            <div class="card">
                                <div class="card-header">
                                    Websites & social channel
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-center mb-3">
                                        <div class="col col-auto">
                                            <div class="icon icofont-github fs-30 github-color"></div>
                                        </div>
                                        <div class="col">
                                            <div>Github</div>
                                            <a href="#">github.com/liam-jouns</a>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mb-3">
                                        <div class="col col-auto">
                                            <div class="icon icofont-twitter fs-30 twitter-color"></div>
                                        </div>
                                        <div class="col">
                                            <div>Twitter</div>
                                            <a href="#">twitter.com/liam-jouns</a>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mb-3">
                                        <div class="col col-auto">
                                            <div class="icon icofont-linkedin fs-30 linkedin-color"></div>
                                        </div>
                                        <div class="col">
                                            <div>Linkedin</div>
                                            <a href="#">linkedin.com/liam-jouns</a>
                                        </div>
                                    </div>

                                    <div class="row align-items-center">
                                        <div class="col col-auto">
                                            <div class="icon icofont-youtube fs-30 youtube-color"></div>
                                        </div>
                                        <div class="col">
                                            <div>YouTube</div>
                                            <a href="#">youtube.com/liam-jouns</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-md-0">
                                <div class="card-header">
                                    Contact information
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-center mb-3">
                                        <div class="col col-auto">
                                            <div class="icon icofont-ui-touch-phone fs-30 text-muted"></div>
                                        </div>
                                        <div class="col">
                                            <div>Mobile</div>
                                            0126596578
                                        </div>
                                    </div>

                                    <div class="row align-items-center mb-3">
                                        <div class="col col-auto">
                                            <div class="icon icofont-slack fs-30 text-muted"></div>
                                        </div>
                                        <div class="col">
                                            <div>Slack</div>
                                            @liam.jouns
                                        </div>
                                    </div>

                                    <div class="row align-items-center mb-3">
                                        <div class="col col-auto">
                                            <div class="icon icofont-skype fs-30 text-muted"></div>
                                        </div>
                                        <div class="col">
                                            <div>Skype</div>
                                            liam0jouns
                                        </div>
                                    </div>

                                    <div class="row align-items-center">
                                        <div class="col col-auto">
                                            <div class="icon icofont-location-pin fs-30 text-muted"></div>
                                        </div>
                                        <div class="col">
                                            <div>Current Address</div>
                                            71 Pilgrim Avenue Chevy Chase, MD 20815
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <form autocomplete="off" wire:submit.prevent="sendMessage">
                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input class="form-control rounded @error('fullname') is-invalid @enderror"
                                                type="text" placeholder="Type full name..."
                                                wire:model.defer="state.fullname" name="fullname">
                                            @error('fullname')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control rounded @error('email') is-invalid @enderror"
                                                type="email" placeholder="Type your email..."
                                                wire:model.defer="state.email" name="email">
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Company/Organization</label>
                                            <input
                                                class="form-control rounded @error('organization') is-invalid @enderror"
                                                type="text" placeholder="Type organization name..."
                                                wire:model.defer="state.organization" name="organization">
                                            @error('organization')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Message</label>
                                            <textarea
                                                class="form-control rounded rounded @error('message') is-invalid @enderror"
                                                rows="4" placeholder="Write Here ..." wire:model.defer="state.message"
                                                name="message"></textarea>
                                            @error('message')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary">Send Message</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if ($action == 'sign-up')
                <div>
                    <div>
                        <div class="row">
                            <div class="col-12 col-md-12 mb-5">
                                <h2 class="text-center">Sign Up</h2>
                                <p class="text-muted mb-4 text-center">Lorem ipsum dolor sit amet, consectetur
                                    adipisicing
                                    elit.
                                    Ab, dolorem
                                    excepturi
                                    facilis magni necessitatibus
                                    perspiciatis repellendus sunt veniam? A ad architecto aspernatur cupiditate
                                    dignissimos
                                    distinctio earum,
                                    eligendi eum
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12 mb-md-0">
                                <div class="card">
                                    <div class="card-body">
                                        <form autocomplete="off" wire:submit.prevent="registerOrg">
                                            <div class="form-group">
                                                <label>Organization/Company Name</label>
                                                <input class="form-control rounded @error('name') is-invalid @enderror"
                                                    type="text" placeholder="Type full name..."
                                                    wire:model.defer="state.name" name="name">
                                                @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label>Organization Type</label>
                                                        <select
                                                            class="form-control rounded @error('organization_type') is-invalid @enderror"
                                                            name="organization_type"
                                                            wire:model.defer="state.organization_type">
                                                            <option class="d-none">Select a type</option>
                                                            @foreach ($orgTypes as $orgType)
                                                            <option value="{{ $orgType->id }}">{{ $orgType->type }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @error('organization_type')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label>Location</label>
                                                        <input
                                                            class="form-control rounded @error('location') is-invalid @enderror"
                                                            type="email" placeholder="Type location..."
                                                            wire:model.defer="state.location" name="location">
                                                        @error('location')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label>Company Email</label>
                                                        <input
                                                            class="form-control rounded @error('email') is-invalid @enderror"
                                                            type="email" placeholder="Type email..."
                                                            wire:model.defer="state.email" name="email">
                                                        @error('email')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label>Company Phone</label>
                                                        <input
                                                            class="form-control rounded @error('phone_number') is-invalid @enderror"
                                                            type="text" placeholder="Type phone number..."
                                                            wire:model.defer="state.phone_number" name="phone_number">
                                                        @error('phone_number')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Send Message</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>

    </main>

    <div class="content-overlay"></div>
</div>
