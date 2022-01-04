<div class="content">
    <div>
        <h2 class="content-heading">{{ $orgName }} </h2>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">All Subscriptions</h3>

                <button type="button" class="btn btn-alt-primary" wire:click="addSubscription">
                    <i class="fa fa-plus mr-5"></i>New Subscription
                </button>
            </div>
            <div class="block-content">
                <table class="table table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th style="width: 100px;">TxID</th>
                            <th>Package</th>
                            <th class="d-none d-md-table-cell">Start Date</th>
                            <th class="d-none d-md-table-cell">End Date</th>
                            <th class="d-none d-md-table-cell text-center">Duration</th>
                            <th class="d-none d-md-table-cell text-center">Status</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (sizeof($subscriptions)>0)
                        @foreach ($subscriptions as $subscription)
                        <tr>
                            <td style="width: 100px;">
                                <span class="font-weight-bold text-primary" href="">#{{
                                    $subscription->payment_ref }}</span>
                            </td>
                            <td class="font-w600 text-primary">
                                <span>
                                    {{ $subscription->package->name }}
                                </span>
                            </td>
                            <td class="d-none d-md-table-cell">
                                {{ \Carbon\Carbon::parse($subscription->start_date)->format('d/m/Y') }}
                            </td>
                            <td class="d-none d-md-table-cell">
                                {{ \Carbon\Carbon::parse($subscription->end_date)->format('d/m/Y') }}
                            </td>
                            <td class="d-none d-md-table-cell text-center">
                                @if ($subscription->duration == 'yearly')
                                <span class="badge badge-secondary"> 1 YEAR </span>
                                @else
                                <span class="badge badge-secondary"> 1 MONTH </span>
                                @endif
                            </td>
                            <td class="d-none d-md-table-cell text-center">
                                @if ($subscription->status == 3)
                                <span class="badge badge-info"> PAID </span>
                                @endif
                                @if ($subscription->status == 2)
                                <span class="badge badge-primary"> SUBSCRIBED </span>
                                @endif
                                @if ($subscription->status == 1)
                                <span class="badge badge-warning"> UNSUBSCRIBED </span>
                                @endif
                                @if ($subscription->status == 4)
                                <span class="badge badge-danger"> BLOCKED </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    {{-- <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip"
                                        title="View" wire:click="viewSubscription({{ $subscription->id }})">
                                        <i class=" fa fa-eye"></i>
                                    </button> --}}
                                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                        title="View" wire:click="editSubscription({{ $subscription->id }})">
                                        <i class=" fa fa-edit"></i>
                                    </button>
                                    @if (Auth::user()->status == '2')
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                        title="View" wire:click="deleteSubModal({{ $subscription->id }})">
                                        <i class=" fa fa-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="mb-15">
                            <td colspan="7" class="text-center">
                                No Subscription Found
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="float-right">
            {{ $subscriptions->links('vendor.livewire.bootstrap') }}
        </div>


        <div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="modal-slideup"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-slideup" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Subscription Details</h3>
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
                                        <td class="font-w600">Patient</td>
                                        <td>{{ $vPatient }}</td>
                                    </tr>
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
                        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-subscription" tabindex="-1" role="dialog" aria-labelledby="modal-popout"
            aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-popout" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">
                                @if($showEditModal)
                                <span> Subscription</span>
                                @else
                                <span> New Subscription</span>
                                @endif
                            </h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <form
                                wire:submit.prevent="{{ $showEditModal ? 'updateSubscription' : 'createSubscription' }}">
                                <div class="form-group row">
                                    <div class="col-sm-12 col-lg-7">
                                        <label for="package_id">Subscription Package</label>
                                        <select class="form-control @error('package_id') is-invalid @enderror"
                                            title="package_id" wire:model="package_id" id="package_id" name="package_id"
                                            size="1" {{ $disabled }}>
                                            <option class="d-none">Select Package</option>
                                            @foreach ($packages as $package)
                                            <option value="{{ $package->id }}">
                                                {{ $package->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('package_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 col-lg-5">
                                        <label for="package_id">Package Duration</label>
                                        <select class="form-control @error('package_duration') is-invalid @enderror"
                                            title="package_duration" wire:model="package_duration" id="package_duration"
                                            name="package_duration" size="1" {{ $disabled }}>
                                            <option class="d-none">Select Duration</option>
                                            <option value="monthly">One Month</option>
                                            <option value="yearly">One Year</option>
                                        </select>
                                        @error('package_duration')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                @if ($package_id != null && $package_duration != null)
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control " wire:model="package_details"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="start_date">Start Date</label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text"
                                            class="js-flatpickr form-control bg-white @error('start_date') is-invalid @enderror"
                                            wire:model.defer="start_date" id="start_date" name="start_date"
                                            placeholder="d-m-Y" data-date-format="d-m-Y" {{ $disabled }}>
                                        @error('start_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                @if($showEditModal)
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="end_date">End Date</label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text"
                                            class="js-flatpickr form-control bg-white @error('end_date') is-invalid @enderror"
                                            wire:model.defer="end_date" id="end_date" name="end_date"
                                            placeholder="d-m-Y" data-date-format="d-m-Y" {{ $disabled }}>
                                        @error('end_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="status">Subscription Status</label>
                                    </div>
                                    <div class="col-12">
                                        <select class="form-control @error('status') is-invalid @enderror"
                                            title="status" wire:model.defer="status" id="status" name="status" size="1">
                                            <option class="d-none">Select Status</option>
                                            <option value="2">Subscribed </option>
                                            <option value="1">UnSubscribed </option>
                                            <option value="3">Paid </option>
                                            {{-- <option value="4">Payment Confirmed</option> --}}
                                            <option value="5">Blocked </option>
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                @if ($showEditModal)
                                <div class="form-group row">
                                    <label class="col-12" for="payment_ref">Payment Ref</label>
                                    <div class="col-12">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control @error('payment_ref') is-invalid @enderror"
                                                wire:model.defer="payment_ref" id="payment_ref" name="payment_ref"
                                                placeholder="Enter your payment_ref.." disabled>
                                            @error('payment_ref')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-alt-info" wire:loading.attr="disabled">
                                            <i class="fa fa-send mr-5"></i>
                                            @if($showEditModal)
                                            Save Changes
                                            @else
                                            Save
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
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
                            <h3 class="block-title">Delete Subscription</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <h5>Are you sure you want to delete this subscription!</h5>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-alt-danger" wire:click.prevent="deleteSubscription">
                            <i class="fa fa-trash"></i> Confirm Delete
                        </button>
                    </div>
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
        });
</script>
<script>
    window.addEventListener('show-subscription-modal', event => {
        $('#modal-subscription').modal('show');
    })

    window.addEventListener('hide-subscription-modal', event => {
        $('#modal-subscription').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })

    window.addEventListener('show-delete-modal', event => {
        $('#delete-modal').modal('show');
    })

    window.addEventListener('hide-delete-modal', event => {
        $('#delete-modal').modal('hide');
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
        toastr.error(event.detail.message, 'Error!');
    })

</script>
@endpush
