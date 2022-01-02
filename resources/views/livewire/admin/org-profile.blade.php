<div class="content">
    <div class="row">
        <!-- User -->
        <div class="col-lg-4 col-xl-3">

            <!-- Worldwide Trends -->
            <div class="block block-rounded">
                <div class="block-header">
                    <h3 class="block-title font-w600">Organization Details</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option">
                            <i class="si si-wrench"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <a class="font-w600" href="javascript:void(0)">Name</a>
                    <p class="text-muted">{{ $organization->name }}</p>
                    <a class="font-w600" href="javascript:void(0)">Location</a>
                    <p class="text-muted">{{ $organization->location }} - {{ $organization->district->name }}, {{
                        $organization->district->region->name }}</p>
                    <a class="font-w600" href="javascript:void(0)">Email</a>
                    <p class="text-muted">{{ $organization->email }}</p>
                    <a class="font-w600" href="javascript:void(0)">Phone</a>
                    <p class="text-muted">{{ $organization->phone_number }}</p>
                    <a class="font-w600" href="javascript:void(0)">#Subscription</a>
                    <p class="text-muted">{{
                        $subscription->end_date ?? '' != '' ? \Carbon\Carbon::parse($subscription->end_date)->format('F
                        j, Y') : ''
                        }}
                        <br>
                        <span class="badge
                        @switch($subscription->status ?? '')
                            @case('1')
                            badge-warning
                                @break
                            @case('2')
                            badge-primary
                                @break
                            @case('3')
                            badge-info
                            @break
                            @case('4')
                            badge-info
                            @break
                            @case('5')
                            badge-danger
                            @break
                            @default
                            badge-secondary
                        @endswitch
                        ">
                            {{ ($subscription->status ?? '-') == '-' ? 'Registered' :
                            $subscription->status() }}
                        </span>
                    </p>

                </div>
            </div>
            <div class="block-options-item text-center pb-15">
                <a href="{{ route('admin.subscriptions', ['id' => $orgId]) }}" type="button"
                    class="btn btn-outline-primary">
                    <i class="fa fa-list-alt mr-5"></i>View Subscriptions
                </a>
            </div>
            <!-- END Worldwide Trends -->
        </div>
        <!-- END User -->

        <!-- Updates -->
        <div class="col-lg-8 col-xl-9">
            <!-- Overview -->
            <div class="row invisible" data-toggle="appear">
                <div class="col-md-4">
                    <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="py-20 text-center">
                                <div class="mb-10">
                                    <i class="fa fa-users fa-3x text-corporate"></i>
                                </div>
                                <div class="font-size-h4 font-w600">{{ $totalPatients }} Patients</div>
                                {{-- <div class="text-muted">{{ $myPatients }} were added by you!</div> --}}
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="py-20 text-center">
                                <div class="mb-10">
                                    <i class="fa fa-calendar fa-3x text-elegance"></i>
                                </div>
                                <div class="font-size-h4 font-w600">{{ $totalAppointments }} Appointments</div>
                                {{-- <div class="text-muted">{{ $myAppointments }} were scheduled by you!</div> --}}
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="py-20 text-center">
                                <div class="mb-10">
                                    <i class="fa fa-user-md fa-3x text-primary"></i>
                                </div>
                                <div class="font-size-h4 font-w600">{{ $totalPrescribers }} Prescribers</div>
                                {{-- <div class="text-muted">You are registered as a {{
                                    Auth::user()->account->type->title }}
                                </div> --}}
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- END Overview -->

            <!-- Appointments -->
            <div class="block block-rounded block-bordered invisible" data-toggle="appear">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Appointments</h3>
                    <div class="block-options">
                        <a href="{{ route('admin.appointments', ['id' => $orgId]) }}" type="button"
                            class="btn btn-alt-primary">
                            <i class="fa fa-calendar mr-5"></i>All Appointments
                        </a>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover table-striped table-vcenter mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 100px;">ID</th>
                                    <th class="d-none d-sm-table-cell">Patient</th>
                                    <th width="30%" class="text-center">Date & Time</th>
                                    <th class="d-none d-md-table-cell">Prescriber</th>
                                    <th class="d-none d-md-table-cell text-center">Visits</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($appointments)>0)
                                @foreach ($appointments as $appointment)
                                <tr>
                                    <td style="width: 100px;">
                                        <a class="font-w600"
                                            href="{{ route('admin.patients.profile', ['code' => $appointment->patient->patient_code, 'org_id' => $orgId]) }}">#{{
                                            $appointment->patient->patient_code }}</a>
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <a
                                            href="{{ route('admin.patients.profile', ['code' => $appointment->patient->patient_code, 'org_id' => $orgId]) }}">{{
                                            $appointment->patient->first_name }} {{
                                            $appointment->patient->last_name }}</a>
                                    </td>
                                    <td width="30%" class="text-center">
                                        {{ $appointment->dateOfVisit() }} {{
                                        \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <span class="">{{
                                            $appointment->prescriber->prescriber_type->initial ?? '' }} {{
                                            $appointment->prescriber->first_name }} {{
                                            $appointment->prescriber->last_name
                                            }}</span>
                                    </td>
                                    <td class="d-none d-md-table-cell text-center">
                                        <span
                                            class="badge {{ $appointment->app_type == 'weekly' ? 'badge-info' : 'badge-success' }}">{{
                                            $appointment->app_type }}</span>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr class="mb-15">
                                    <td colspan="5" class="text-center">
                                        No Appointment Found
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END Appointments -->

            <div class="block block-rounded block-bordered invisible" data-toggle="appear">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Prescribers</h3>
                    <div class="block-options">
                        @if (sizeof($prescribers) == 0)
                        <a href="{{ route('admin.prescribers', ['id' => $orgId]) }}" type="button"
                            class="btn btn-alt-primary">
                            <i class="fa fa-plus mr-5"></i>Add Presscriber
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- <h2 class="content-heading">Current Prescribers</h2> --}}
            @if (sizeof($prescribers)>0)
            <div class="row">
                @foreach ($prescribers as $prescriber)
                <div class="col-md-6 col-xl-4">
                    <a class="block block-link-pop text-center"
                        href="{{ route('admin.prescribers.profile', ['id' => $prescriber->prescriber_code, 'org_id' => $orgId]) }}">
                        <div class="block-content block-content-full">
                            <img class="img-avatar" src="{{ $prescriber->photoUrl() }}" alt="">
                        </div>
                        <div class="block-content block-content-full bg-body-light">
                            <div class="font-w600 mb-5">{{ $prescriber->first_name }} {{ $prescriber->last_name }}</div>
                            <div class="font-size-sm text-muted">{{ $prescriber->type->title ?? ''}}</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="row mb-15">
                <div class="col-sm-12 col-xl-12 text-center">
                    <a href="{{ route('admin.prescribers', ['id' => $orgId]) }}" type="button"
                        class="btn btn-primary min-width-125">View
                        All</a>
                </div>
            </div>
            @else
            <div class="row mb-15">
                <div class="col-sm-12 col-xl-12 text-center">
                    No Prescriber Found
                </div>
            </div>
            @endif

            <h2 class="content-heading">Current Patients</h2>
            @if (sizeof($patients)>0)
            <div class="row">
                <!-- Row #1 -->
                @foreach ($patients as $patient)
                @if ($patient->lastAppointment->date_of_visit ?? '' >= now())
                <div class="col-md-6 col-xl-4">
                    <a class="block text-center"
                        href="{{ route('admin.patients.profile', ['code' => $patient->patient_code, 'org_id' => $orgId]) }}">
                        <div class="block-content block-content-full bg-gd-dusk">
                            <img class="img-avatar img-avatar-thumb"
                                src="{{ $patient->photo == null ? asset('assets/base/media/avatars/avatar.jpg') : asset($patient->photo) }}"
                                alt="">
                        </div>
                        <div class="block-content block-content-full">
                            <div class="font-w600 mb-5">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                            <div class="font-size-sm text-muted">#{{ $patient->patient_code }}</div>
                        </div>
                    </a>
                </div>
                @else
                <div class="col-md-6 col-xl-4">
                    <a class="block block-link-pop text-center"
                        href="{{ route('admin.patients.profile', ['code' => $patient->patient_code, 'org_id' => $orgId]) }}">
                        <div class="block-content block-content-full">
                            <img class="img-avatar img-avatar-thumb"
                                src="{{ $patient->photo == null ? asset('assets/base/media/avatars/avatar.jpg') : asset($patient->photo) }}"
                                alt="">
                        </div>
                        <div class="block-content block-content-full bg-body-light">
                            <div class="font-w600 mb-5">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                            <div class="font-size-sm text-muted">#{{ $patient->patient_code }}</div>
                        </div>
                    </a>
                </div>
                @endif
                @endforeach
            </div>
            <div class="row mb-15">
                <div class="col-sm-12 col-xl-12 text-center">
                    <a href="{{ route('admin.patients', ['id' => $orgId]) }}" type="button"
                        class="btn btn-primary min-width-125">View All</a>
                </div>
            </div>
            @else
            <div class="row mb-15">
                <div class="col-sm-12 col-xl-12 text-center">
                    No Patient Found
                </div>
            </div>
            @endif


            <h2 class="content-heading">Treatment Supporters</h2>
            @if (sizeof($supporters)>0)
            <div class="row">
                @foreach ($supporters as $supporter)
                <div class="col-md-6 col-xl-4">
                    <a class="block block-link-shadow" href="javascript:void(0)"
                        wire:click.prevent="viewSupporter({{ $supporter->id }})">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-right">
                                <img class="img-avatar"
                                    src="{{ $supporter->photo == null ? asset('assets/img/default-profile.png') : asset($supporter->photo) }}"
                                    alt="">
                            </div>
                            <div class="float-left mt-10">
                                <div class="font-w600 mb-5">{{ $supporter->full_name }}</div>
                                <div class="font-size-sm text-muted">{{ $supporter->patients()->count() }} Patient(s)
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="row mb-15">
                <div class="col-sm-12 col-xl-12 text-center">
                    <a href="{{ route('admin.supporters', ['id' => $orgId]) }}" type="button"
                        class="btn btn-primary min-width-125">View All</a>
                </div>
            </div>
            @else
            <div class="row mb-15">
                <div class="col-sm-12 col-xl-12 text-center">
                    No Supporter Found
                </div>
            </div>
            @endif


        </div>
        <!-- END Updates -->
    </div>

    <div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="modal-slideup"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-slideup" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Treatment Supporter's Details</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <table class="table table-striped table-borderless mt-20">
                            <tbody>
                                <tr>
                                    <td class="font-w600">Full Name</td>
                                    <td>{{ $viewState['full_name'] ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Phone Number</td>
                                    <td>{{ $viewState['phone_number'] ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Email</td>
                                    <td>{{ $viewState['email'] ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Location</td>
                                    <td>
                                        {{ $viewState['location'] ?? '' }} - {{ $viewState['district'] ?? '' }}, {{
                                        $viewState['region'] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Patients</td>
                                    <td>
                                        @foreach ($viewState['patients'] ?? [] as $patient)
                                        <a
                                            href="{{ route('admin.patients.profile', ['code' => $patient->patient_code ?? '0', 'org_id' => $orgId]) }}">{{
                                            $patient->first_name ?? '' }} {{ $patient->last_name ?? ''
                                            }}</a> <br>
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "progressBar": true,
        }
    });
</script>
<script>
    window.addEventListener('show-view-modal', event => {
        $('#view-modal').modal('show');
    })

    window.addEventListener('hide-view-modal', event => {
        $('#view-modal').modal('hide');
        // window.location.href = event.detail.url;
        // toastr.success(event.detail.message, 'Success!');
    })

    window.addEventListener('show-error-toastr', event => {
        toastr.error(event.detail.message, 'Error!');
    })

</script>
@endpush



@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/icofont.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/jquery.barrating.min.js') }}"></script>
@endpush
