<div class="main-content-wrap">
    <div class="page-content">
        <div class="row">
            <div class="col col-12 col-md-6 col-xl-3">
                <div class="card animated fadeInUp delay-01s bg-light">
                    <div class="card-body">

                        <div class="row align-items-center">
                            <div class="col col-5">
                                <div class="icon p-0 fs-48 text-primary opacity-50 icofont-first-aid-alt">
                                </div>
                            </div>
                            <div class="col col-7">
                                <a href="">
                                    <h6 class="mt-0 mb-1">Appointments</h6>
                                </a>
                                <div class="count text-primary fs-20">{{ $org->appointments()->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col col-12 col-md-6 col-xl-3">
                <div class="card animated fadeInUp delay-02s bg-light">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col col-5">
                                <div class="icon p-0 fs-48 text-primary opacity-50 icofont-wheelchair">
                                </div>
                            </div>

                            <div class="col col-7">
                                <h6 class="mt-0 mb-1">Patients</h6>
                                <div class="count text-primary fs-20">{{ $org->patients()->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col col-12 col-md-6 col-xl-3">
                <div class="card animated fadeInUp delay-03s bg-light">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col col-5">
                                <div class="icon p-0 fs-48 text-primary opacity-50 icofont-blood"></div>
                            </div>

                            <div class="col col-7">
                                <h6 class="mt-0 mb-1">Prescribers</h6>
                                <div class="count text-primary fs-20">{{ $org->prescribers()->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col col-12 col-md-6 col-xl-3">
                <div class="card animated fadeInUp delay-04s bg-light">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col col-5">
                                <div class="icon p-0 fs-48 text-primary opacity-50 icofont-dollar-true">
                                </div>
                            </div>

                            <div class="col col-7">
                                <h6 class="mt-0 mb-1 text-nowrap"> Supporters</h6>
                                <div class="count text-primary fs-20">{{ $org->supporters()->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-header">
                        {{ $org->name }}
                    </div>
                    <div class="card-body">
                        <h6 class="mt-0 mb-0">Address</h6>
                        <p>{{ $org->location }} - {{ $org->district->name }}, {{ $org->district->region->name }}</p>
                        <h6 class="mt-0 mb-0">Email</h6>
                        <p>{{ $org->email }} </p>
                        <h6 class="mt-0 mb-0">Phone</h6>
                        <p>{{ $org->phone_number }}</p>

                        @if (!empty($subscription->status))
                        @if ($subscription->status == \App\Models\OrganizationSubscription::PAID)
                        <a href="{{ route('admin.subscriptions', $org->id) }}" class="btn btn-secondary">
                            Confirm Now!<span class="btn-icon icofont-question-circle ml-2"></span>
                        </a>
                        @elseif ($subscription->status == \App\Models\OrganizationSubscription::SUBSCRIBED)
                        <a href="{{ route('admin.subscriptions', $org->id) }}" class="btn btn-outline-light">
                            Subscribed<span class="btn-icon icofont-check-circled ml-2"></span>
                        </a>
                        @elseif ($subscription->status == \App\Models\OrganizationSubscription::UNSUBSCRIBED ||
                        empty($subscription->status))
                        <a href="{{ route('admin.subscriptions', $org->id) }}" class="btn btn-warning">
                            UnSubscribed<span class="btn-icon icofont-lock ml-2"></span>
                        </a>
                        @elseif ($subscription->status == \App\Models\OrganizationSubscription::BLOCKED)
                        <a href="{{ route('admin.subscriptions', $org->id) }}" class=" btn btn-danger">
                            Blocked<span class="btn-icon icofont-ban ml-2"></span>
                        </a>
                        @endif
                        @else
                        <a href="{{ route('admin.subscriptions', $org->id) }}"
                            class="btn btn-outline btn-light text-light">
                            Add Subscriptions<span class="btn-icon icofont-plus ml-2"></span>
                        </a>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Latest Patients
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Patient</th>
                                    <th scope="col" class="text-right">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patients as $patient)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $patient->photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($patient->photo) }}"
                                                alt="" width="40" height="40" class="rounded-500 mr-3">
                                            <strong>{{ $patient->first_name }} {{ $patient->last_name }}</strong>
                                        </div>
                                    </td>
                                    <td class="text-right text-muted">
                                        {{ \Carbon\Carbon::parse($patient->created_at)->format('M d, Y') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('admin.patients', [$org->id]) }}" type="button"
                            class="btn btn-secondary btn-block">View All</a>
                    </div>
                </div>

                <div class="card mb-md-0">
                    <div class="card-header">
                        Top Supporters
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col" class="text-center">Patient(s)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($supporters as $supporter)
                                <tr>
                                    <td class="text-muted">{{ $supporter->full_name }}</td>
                                    <td class="text-center"><span
                                            class="badge badge-success rounded-0">{{ $supporter->patients }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('admin.supporters', [$org->id]) }}" type="submit"
                            class="btn btn-secondary btn-block">View All</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8">
                <div class="card mb-0">
                    <div class="card-header">
                        Latest Appointments
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Photo</th>
                                        <th scope="col" class="text-center">Name</th>
                                        <th scope="col" class="text-center">Phone</th>
                                        <th scope="col" class="text-center">Date</th>
                                        <th scope="col" class="text-center">Visit Time</th>
                                        <th scope="col" class="text-center">Prescriber</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (sizeof($appointments)>0)
                                    @foreach ($appointments as $appointment)
                                    <tr>
                                        <td>
                                            <img src="{{ $appointment->photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($appointment->photo) }}"
                                                alt="" width="40" height="40" class="rounded-500">
                                        </td>
                                        <td align="center">
                                            <strong>{{ $appointment->pf_name }} {{ $appointment->pl_name }}</strong>
                                        </td>
                                        <td align="center">
                                            <div class="text-muted text-nowrap">{{ $appointment->phone_number }}</div>
                                        </td>
                                        <td align="center">
                                            <div class="text-muted text-nowrap">
                                                {{ \Carbon\Carbon::parse($appointment->date_of_visit)->format('d/m/Y')  }}
                                            </div>
                                        </td>
                                        <td align="center">
                                            <div class="text-muted text-nowrap">
                                                {{ \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}
                                            </div>
                                        </td>
                                        <td align="center">{{ $appointment->initial }} {{ $appointment->first_name }}
                                            {{ $appointment->last_name }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6" align="center">No Appointment Found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <a href="{{ route('admin.appointments', [$org->id]) }}"
                        class="btn btn-block btn-outline-primary">View All Appointments</a>
                </div>
                <br><br>

                <div class="card mb-0">
                    <div class="card-header">
                        Prescribers
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if (sizeof($prescribers)>0)
                            @foreach ($prescribers as $prescriber)
                            <div class="col-12 col-md-6">
                                <div class="contact">
                                    <div class="img-box">
                                        <img src="{{ $prescriber->profile_photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($prescriber->profile_photo) }}"
                                            width="400" height="400" alt="">
                                    </div>

                                    <div class="info-box">
                                        <h4 class="name">{{ $prescriber->initial }} {{ $prescriber->first_name }}
                                            {{ $prescriber->last_name }}</h4>

                                        <p class="role">{{ $prescriber->title }}</p>

                                        <div class="social">
                                            <a href="#" class="link icofont-email"></a>
                                            <a href="#" class="link icofont-phone"></a>
                                            <span wire:click.prevent="editPrescriber({{ $prescriber->id }})"
                                                class="link icofont-edit"></span>
                                        </div>

                                        <p class="address">{{ $prescriber->email }}</p>

                                        <div class="button-box">
                                            <a href="doctor.html" class="btn btn-primary">View profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            @else
                            <div class="col-12">
                                <div class="contact">
                                    <div class="info-box">
                                        <p class="address">No Prescriber found</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                    </div>
                    <a href="{{ route('admin.prescribers', [$org->id]) }}"
                        class="btn btn-block btn-outline-primary">View All Prescriber</a>
                </div>

            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/icofont.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/jquery.barrating.min.js') }}"></script>
@endpush
