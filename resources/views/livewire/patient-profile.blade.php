<div>
    <div class="row">
        <!-- User -->
        <div class="col-lg-4 col-xl-3">
            <!-- Account -->
            <div class="block block-rounded font-w600">
                <div class="block-content block-content-full bg-gd-sea text-center">
                    <img class="img-avatar img-avatar-thumb" src="{{ $patient->photoUrl() }}" alt="">
                </div>
                <div class="block-content block-content-full text-center">
                    <div class="border-b pb-15">
                        {{ $patient->first_name }} {{ $patient->last_name }}<br>
                        <a class="text-muted font-w400" href="javascript:void(0)"> {{ Str::ucfirst($patient->gender) }}
                            - {{
                            \Carbon\Carbon::parse($patient->date_of_birth)->age }} Years Old</a>
                    </div>
                </div>
                <div class="block-content pull-t">
                    <a class="font-w600" href="javascript:void(0)">Patient Code</a>
                    <p class="text-muted">#{{ $patient->patient_code }}</p>
                    <a class="font-w600" href="javascript:void(0)">Location</a>
                    <p class="text-muted">{{ $patient->location }} - {{ $patient->district->region->name }}, {{
                        $patient->district->name }}</p>
                    @if ($patient->email ?? '' != '' )
                    <a class="font-w600" href="javascript:void(0)">Email</a>
                    <p class="text-muted">{{ $patient->email ?? '- - -' }}</p>
                    @endif
                    <a class="font-w600" href="javascript:void(0)">Phone</a>
                    <p class="text-muted">{{ $patient->phone_number ?? '- - -' }}</p>
                    <a class="font-w600" href="javascript:void(0)">Appointments</a>
                    <p class="text-muted">{{ $patient->appointments->count() }}</p>
                    @if ($patient->tensel_leader ?? '' != '' )
                    <a class="font-w600" href="javascript:void(0)">Tensel Leader</a>
                    <p class="text-muted">{{ $patient->tensel_leader ?? '- - -' }}</p>
                    @endif
                    @if ($patient->tensel_leader_phone ?? '' != '' )
                    <a class="font-w600" href="javascript:void(0)">Tensel Leader's Phone</a>
                    <p class="text-muted">{{ $patient->tensel_leader_phone ?? '- - -' }}</p>
                    @endif
                    @if (is_subscribed())
                    @if (Auth::user()->isAdmin())
                    <div class="block-options-item text-center pb-15">
                        <button type="button" class="btn btn-alt-info" wire:click="editPatient">
                            <i class="fa fa-edit mr-5"></i>Edit Patient Details
                        </button>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
            <!-- END Account -->
            <br>
            <div class="block block-rounded font-w600">
                <div class="block-content bg-gd-sea text-center">
                    <div class="pb-15 text-white">
                        Treatment Supporter<br>
                    </div>
                </div>
                @if ($patient->supporter_id == NULL)
                @if (is_subscribed())
                <div class="block-options-item text-center p-10">
                    <button type="button" class="btn btn-alt-primary" wire:click="addSupporter">
                        <i class="fa fa-plus mr-5"></i>Add Supporter
                    </button>
                </div>
                <br>
                <div class="block-options-item text-center">
                    <address>
                        <a href="{{ route('patients.supporters') }}">View All Supporters</a>
                    </address>
                </div>
                @endif
                @else
                <div class="block-content pull-t mt-0">
                    <a class="font-w600" href="javascript:void(0)">Supporter' Name</a>
                    <p class="text-muted">{{ $patient->supporter->full_name }}</p>
                    <a class="font-w600" href="javascript:void(0)">Location</a>
                    <p class="text-muted">{{ $patient->supporter->location }} - {{
                        $patient->supporter->district->region->name }}, {{
                        $patient->supporter->district->name }}</p>
                    @if ($patient->supporter->email ?? '' != '')
                    <a class="font-w600" href="javascript:void(0)">Email</a>
                    <p class="text-muted">{{ $patient->supporter->email ?? '- - -' }}</p>
                    @endif
                    <a class="font-w600" href="javascript:void(0)">Phone</a>
                    <p class="text-muted">{{ $patient->supporter->phone_number ?? '- - -' }}</p>
                    @if (Auth::user()->isAdmin())
                    @if (is_subscribed())
                    <div class="block-options-item text-center">
                        <button type="button" class="btn btn-alt-info" wire:click="editSupporter">
                            <i class="fa fa-edit mr-5"></i>Change Supporter
                        </button>
                    </div>
                    @endif
                    @endif
                    <br>
                    <div class="block-options-item text-center">
                        <address>
                            <a href="{{ route('patients.supporters') }}">View All Supporters</a>
                        </address>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <!-- END User -->

        <!-- Updates -->
        <div class="col-lg-8 col-xl-9">
            <div class="block block-rounded block-bordered">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Patient's Appointments</h3>
                    <div class="block-options">
                        <div class="block-options-item">
                            @if (is_subscribed())
                            <button type="button" class="btn btn-alt-primary" wire:click="addAppointment">
                                <i class="fa fa-calendar-plus-o mr-5"></i>New Appointment
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="block-content">
                    <table class="table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th class="d-none d-sm-table-cell">Prescriber</th>
                                <th width="30%">Date</th>
                                <th class="d-none d-sm-table-cell text-center">Reminder</th>
                                <th class="text-center" style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($appointments)>0)
                            @foreach ($appointments as $appointment)
                            <tr>
                                <td class="d-none d-sm-table-cell"><a href="javascript:void(0)">{{
                                        $appointment->prescriber->prescriber_type->initial ?? '' }} {{
                                        $appointment->prescriber->first_name }} {{ $appointment->prescriber->last_name
                                        }}</a></td>
                                <td width="30%">
                                    {{ $appointment->dateOfVisit() }} {{
                                    \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}
                                </td>
                                <td class="d-none d-sm-table-cell text-center">
                                    <span
                                        class="badge {{ $appointment->app_type == 'weekly' ? 'badge-info' : 'badge-success' }}">{{
                                        $appointment->app_type }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        @if ($appointment->visited() == \App\Models\Appointment::NOT_VISITED)
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                            title="Not Visited" wire:click="viewAppointmentModal('{{ $appointment->id }}', '{{
                                        $appointment->prescriber->type->initial ?? '' }} {{
                                        $appointment->prescriber->first_name }} {{ $appointment->prescriber->last_name
                                        }}', '{{ \Carbon\Carbon::parse($appointment->date_of_visit)->format('l, F jS, Y') }}', '{{ \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}',  '{{ $appointment->app_type }}', '{{ $appointment->condition->condition }}', '{{
                                        $appointment->received_by->prescriber_type->initial ?? '' }} {{
                                        $appointment->received_by->first_name ?? '' }} {{ $appointment->received_by->last_name ?? ''
                                        }}', false)">
                                            <i class="fa fa-calendar-times-o"></i>
                                        </button>
                                        @elseif ($appointment->visited() == \App\Models\Appointment::VISITED)
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-success" data-toggle="tooltip"
                                                title="Visited" wire:click="viewAppointmentModal('{{ $appointment->id }}', '{{
                                        $appointment->prescriber->prescriber_type->initial ?? '' }} {{
                                        $appointment->prescriber->first_name }} {{ $appointment->prescriber->last_name
                                        }}', '{{ \Carbon\Carbon::parse($appointment->date_of_visit)->format('l, F jS, Y') }}', '{{ \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}',  '{{ $appointment->app_type }}', '{{ $appointment->condition->condition }}', '{{
                                        $appointment->receiver->prescriber_type->initial ?? '' }} {{
                                        $appointment->receiver->first_name ?? '' }} {{ $appointment->receiver->last_name ?? ''
                                        }}', false)">
                                                <i class="fa fa-check-square-o"></i>
                                            </button>
                                        </div>
                                        @else
                                        @if (Auth::user()->isAdmin() || $appointment->prescriber_id ==
                                        Auth::user()->account->id)
                                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                            title="Confirm" wire:click="completeModal({{ $appointment->id }})">
                                            <i class="fa fa-calendar-check-o"></i>
                                        </button>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                            title="View" wire:click="viewAppointmentModal('{{ $appointment->id }}', '{{
                                        $appointment->prescriber->prescriber_type->initial ?? '' }} {{
                                        $appointment->prescriber->first_name }} {{ $appointment->prescriber->last_name
                                        }}', '{{ \Carbon\Carbon::parse($appointment->date_of_visit)->format('l, F jS, Y') }}', '{{ \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}',  '{{ $appointment->app_type }}', '{{ $appointment->condition->condition }}', '{{
                                        $appointment->receiver->prescriber_type->initial ?? '' }} {{
                                        $appointment->receiver->first_name ?? '' }} {{ $appointment->receiver->last_name ?? ''
                                        }}', {{ $appointment->prescriber_id }})">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr class="mt-5">
                                <td colspan="4" class="text-center text-info mt-5">No Appointment Found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- END Updates -->
    </div>

    <div class="modal fade" id="modal-patient" tabindex="-1" role="dialog" aria-labelledby="modal-popout"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">
                            <span>Edit Patient</span>
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form wire:submit.prevent="updatePatient">
                            <div class="form-group row">
                                <div class="col-12 col-sm-12 text-center">
                                    <div class="form-group avatar-box">
                                        <div class="img-box" onclick="document.getElementById('browsed_photo').click();"
                                            style="cursor: pointer">
                                            @if ($browsed_photo)
                                            <img src="{{ $browsed_photo->temporaryUrl() }}" width="150" height="150"
                                                alt="">
                                            @else
                                            <img src="{{ $profilePhoto == null ? asset('assets/images/add_user.jpg') : asset($profilePhoto) }}"
                                                width="150" height="150" alt="">
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <button class="btn btn-outline-primary self-center" type="button"
                                        id="browseImg" type="button"
                                        onclick="document.getElementById('photo').click();">
                                        Browse Image
                                    </button> --}}
                                    <br>
                                    @error('browsed_photo')
                                    <div class="text-danger italic">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <input wire:model="browsed_photo" type="file" accept="image/*" style="display:none;"
                                        id="browsed_photo" name="browsed_photo">
                                    {{-- @if ($browsed_photo)
                                    {{ $browsed_photo->getClientOriginalName() }}
                                    @endif --}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="firstname">Firstname</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                        wire:model.defer="first_name" id="first_name" name="first_name"
                                        placeholder="Enter your firstname..">
                                    @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="lastname">Lastname</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                        wire:model.defer="last_name" id="last_name" name="last_name"
                                        placeholder="Enter your lastname..">
                                    @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="date_of_birth">Date of Birth</label>
                                    <input type="text"
                                        class="js-flatpickr form-control bg-white @error('date_of_birth') is-invalid @enderror"
                                        wire:model.defer="date_of_birth" id="date_of_birth" name="date_of_birth"
                                        placeholder="d-m-Y" data-date-format="d-m-Y">
                                    @error('date_of_birth')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="gender">Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" title="Gender"
                                        wire:model.defer="gender" id="gender" name="gender" size="1">
                                        <option value="" class="d-none">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    @error('gender')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12" for="phone_number">Phone Number</label>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            wire:model.defer="phone_number" id="phone_number" name="phone_number"
                                            placeholder="Enter your phone number..">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-phone"></i>
                                            </span>
                                        </div>
                                        @error('phone_number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12" for="email">Email</label>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            wire:model.defer="email" id="email" name="email"
                                            placeholder="Enter your email..">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-envelope-o"></i>
                                            </span>
                                        </div>
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12" for="location">Location</label>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('location') is-invalid @enderror"
                                            wire:model.defer="location" id="location" name="location"
                                            placeholder="Enter your location..">
                                        @error('location')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="region_id">Region</label>
                                    <select class="form-control @error('region_id') is-invalid @enderror"
                                        title="Region Name" wire:model="region_id" id="region_id" name="region_id"
                                        size="1">
                                        <option value="" class="d-none">Select Region</option>
                                        @foreach ($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('region_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="district_id">District</label>
                                    <select class="form-control @error('district_id') is-invalid @enderror"
                                        title="District Name" wire:model.defer="district_id" id="district_id"
                                        name="district_id" size="1">
                                        <option value="" class="d-none">Select District</option>
                                        @foreach ($districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('district_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12" for="tensel_leader">Tensel Leader</label>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control @error('tensel_leader') is-invalid @enderror"
                                            wire:model.defer="tensel_leader" id="tensel_leader" name="tensel_leader"
                                            placeholder="Enter your tensel leader's name..">
                                        @error('tensel_leader')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12" for="tensel_leader_phone">Tensel Leader's Phone</label>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control @error('tensel_leader_phone') is-invalid @enderror"
                                            wire:model.defer="tensel_leader_phone" id="tensel_leader_phone"
                                            name="tensel_leader_phone" placeholder="Enter tensel leader's phone..">
                                        @error('tensel_leader_phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if (Auth::user()->isAdmin())
                            <div class="form-group row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-alt-info" wire:loading.attr="disabled">
                                        <i class="fa fa-send mr-5"></i>
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-supporter" tabindex="-1" role="dialog" aria-labelledby="modal-popout"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">
                            <span>Treatment Supporter</span>
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form wire:submit.prevent="updateSupporter">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="supporter_id">Treatment Supporter </label>
                                    <select class="form-control @error('supporter_id') is-invalid @enderror"
                                        title="Supporter Name" wire:model="state.supporter_id" id="supporter_id"
                                        name="supporter_id" size="1">
                                        <option value="" class="d-none">Pick Treatment Supporter</option>
                                        @foreach ($supporters as $supporter)
                                        <option value="{{ $supporter->id }}">{{ $supporter->full_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supporter_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- @if (Auth::user()->isAdmin()) --}}
                            <div class="form-group row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-alt-info" wire:loading.attr="disabled">
                                        <i class="fa fa-send mr-5"></i>
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                            {{-- @endif --}}
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    @if ($changeSupporter)
                    <button type="button" class="btn btn-alt-danger" wire:click="UnAssignSupporter">
                        <i class="fa fa-trash"></i> Unassign Supporter
                    </button>
                    @endif
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-appointment" tabindex="-1" role="dialog" aria-labelledby="modal-popout"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">
                            @if($showEditModal)
                            <span>Edit Appointment</span>
                            @else
                            <span>New Appointment</span>
                            @endif
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form wire:submit.prevent="{{ $showEditModal ? 'updateAppointment' : 'createAppointment' }}">
                            <div class="form-group row">
                                <label class="col-12" for="condition">Condition/Disease</label>
                                <div class="col-12">
                                    <select class="form-control @error('condition_id') is-invalid @enderror"
                                        title="Condition/Disease Name" wire:model="state.condition_id" id="condition_id"
                                        name="condition_id" size="1">
                                        <option value="" class="d-none">Select Condition</option>
                                        @foreach ($conditions as $condition)
                                        <option value="{{ $condition->id }}">{{ $condition->condition }}</option>
                                        @endforeach
                                        <option value="NEW">New Condition/Disease</option>
                                    </select>
                                    @error('condition_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            @if (!$showEditModal)
                            @if (Str::contains($state['condition_id'] ?? '', 'NEW'))
                            <div class="form-group row">
                                <label class="col-12" for="new_condition">New Condition/Disease</label>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control @error('new_condition') is-invalid @enderror"
                                            wire:model.defer="state.new_condition" id="new_condition"
                                            name="new_condition" placeholder="Enter your new condition..">
                                        @error('new_condition')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="date_of_visit">Date of Visit</label>
                                    <input type="text"
                                        class="js-flatpickr form-control bg-white @error('date_of_visit') is-invalid @enderror"
                                        wire:model.defer="state.date_of_visit" id="date_of_visit" name="date_of_visit"
                                        placeholder="d-m-Y" data-date-format="d-m-Y">
                                    @error('date_of_visit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="visit_time">Visiting Time</label>
                                    <input type="text"
                                        class="js-flatpickr form-control bg-white @error('visit_time') is-invalid @enderror"
                                        wire:model.defer="state.visit_time" id="visit_time" name="visit_time"
                                        data-enable-time="true" data-no-calendar="true" data-date-format="H:i"
                                        data-time_24hr="true" placeholder="H : m">
                                    @error('visit_time')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12">Appointment Type</label>
                                <div class="col-12">
                                    <div class="custom-control custom-radio custom-control-inline mb-5">
                                        <input wire:model.defer="state.app_type" class="custom-control-input"
                                            type="radio" name="app_type" id="weekly" value="weekly">
                                        <label class="custom-control-label" for="weekly">Weekly Visits</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline mb-5">
                                        <input wire:model.defer="state.app_type" class="custom-control-input"
                                            type="radio" name="app_type" id="daily" value="daily">
                                        <label class="custom-control-label" for="daily">Daily Visits</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    @if($showEditModal)
                                    <button type="submit" class="btn btn-alt-info" wire:loading.attr="disabled">
                                        <i class="fa fa-send mr-5"></i> Save Changes
                                    </button>
                                    @else
                                    <button type="submit" class="btn btn-alt-info" wire:loading.attr="disabled">
                                        <i class="fa fa-send mr-5"></i> Save
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    @if ($showEditModal)
                    <button type="button" class="btn btn-alt-danger" wire:click="deleteModal()">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                    @endif
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modal-slideup"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideup" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Delete Appointment</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <h5>Are you sure you want to delete this appointment, the patient will be notified?</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-alt-danger" wire:click.prevent="deleteAppointment">
                        <i class="fa fa-trash"></i> Confirm Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="complete-modal" tabindex="-1" role="dialog" aria-labelledby="modal-slideup"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideup" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Patient's Appointment</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <h6 class="p-5">By click the button below the system will record that you have confirmed the
                            patient had attend his/her appointment.</h6>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-alt-success" wire:click.prevent="confirmCompletion">
                        <i class="fa fa-calendar-check-o"></i> Confirm Attendance
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="modal-slideup"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideup" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Patient's Appointment</h3>
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
                                    <td class="font-w600">Prescriber</td>
                                    <td>{{ $vPrescriber }}</td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Date</td>
                                    <td>{{ $vDate }}</td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Time</td>
                                    <td>{{ $vTime }}</td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Condition/Disease</td>
                                    <td>
                                        {{ $vCondition }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Appointment Type</td>
                                    <td>
                                        {{ $vType }} Visits
                                    </td>
                                </tr>
                                @if ($vReceiver != '')
                                <tr>
                                    <td class="font-w600">Attendence Confirmed by</td>
                                    <td>{{ $vReceiver }} </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    @if (is_subscribed())
                    @if ($showEditModal)
                    <button type="button" class="btn btn-alt-info" wire:click="editAppointment({{ $appointmentId }})">
                        <i class="fa fa-edit"></i> Edit Appointment
                    </button>
                    @endif
                    @endif
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    jQuery(function(){Codebase.helpers(['flatpickr', 'datepicker']);});
</script>
<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "progressBar": true,
        }

        window.addEventListener('hide-appointment-modal', event => {
            $('#modal-appointment').modal('hide');
            if(event.detail.message != 'none'){
                toastr.success(event.detail.message, 'Success!');
            }
        })

        window.addEventListener('hide-condition-modal', event => {
            $('#modal-condition').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('hide-patient-modal', event => {
            $('#modal-patient').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('hide-supporter-modal', event => {
            $('#modal-supporter').modal('hide');
            if (event.detail.message != 'none') {
                toastr.success(event.detail.message, 'Success!');
            }
            if (event.detail.url != 'none') {
            window.location.href = event.detail.url;
            }
        })
    });
</script>
<script>
    window.addEventListener('show-patient-modal', event => {
        $('#modal-patient').modal('show');
    })

    window.addEventListener('show-supporter-modal', event => {
        $('#modal-supporter').modal('show');
    })

    window.addEventListener('show-appointment-modal', event => {
        $('#modal-appointment').modal('show');
    })

    window.addEventListener('show-condition-modal', event => {
        $('#modal-condition').modal('show');
    })

    window.addEventListener('show-delete-modal', event => {
        $('#delete-modal').modal('show');
    })

    window.addEventListener('hide-delete-modal', event => {
        $('#delete-modal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })

    window.addEventListener('show-complete-modal', event => {
        $('#complete-modal').modal('show');
    })

    window.addEventListener('hide-complete-modal', event => {
        $('#complete-modal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })

    window.addEventListener('show-view-modal', event => {
        $('#view-modal').modal('show');
    })

    window.addEventListener('hide-view-modal', event => {
        $('#view-modal').modal('hide');
        // toastr.success(event.detail.message, 'Success!');
    })

    window.addEventListener('show-error-toastr', event => {
        $('#complete-modal').modal('hide');
        toastr.error(event.detail.message, 'Error!');
    })

    //  window.addEventListener('show-delete-modal', event => {
    //     $('#confirmationModal').modal('show');
    // })

    // window.addEventListener('hide-delete-modal', event => {
    //     $('#confirmationModal').modal('hide');
    //     toastr.success(event.detail.message, 'Success!');
    // })

        // window.addEventListener('hide-appointment-modal', event => {
        //     $('#add-admin').modal('hide');
        // })
</script>
@endpush
