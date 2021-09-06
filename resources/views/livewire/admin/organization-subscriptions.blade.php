<div>
    <div class="main-content-wrap">
        <header class="page-header">
            <h4 class="page-title">{{ $org->name }}'s Subscriptions</h4>
        </header>

        <div class="page-content">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Package</th>
                                    <th scope="col">Paid By</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Payment Ref</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($subscriptions)>0)
                                @foreach ($subscriptions as $subscription)
                                <tr>
                                    <td>
                                        <strong>{{ $subscription->package }}</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center nowrap text-primary">
                                            <span class="icofont-ui-user p-0 mr-2"></span>
                                            {{ $subscription->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted text-nowrap">
                                            {{ \Carbon\Carbon::parse($subscription->start_date)->format('d/m/Y')  }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted text-nowrap">
                                            {{ \Carbon\Carbon::parse($subscription->end_date)->format('d/m/Y')  }}
                                        </div>
                                    </td>
                                    <td>{{ $subscription->payment_ref }} </td>
                                    <td>{{ $subscription->total_price }}</td>
                                    <td>
                                        <div class="actions">
                                            @if ($subscription->status == 'Paid')
                                            <a href="#" class="badge badge-secondary">{{ $subscription->status }}</a>
                                            @endif
                                            @if ($subscription->status == 'Subscribed')
                                            <a href="#" class="badge badge-success">{{ $subscription->status }}</a>
                                            @endif
                                            @if ($subscription->status == 'UnSubscribed')
                                            <a href="#" class="badge badge-warning">{{ $subscription->status }}</a>
                                            @endif
                                            @if ($subscription->status == 'Blocked')
                                            <a href="#" class="badge badge-danger">{{ $subscription->status }}</a>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="actions">

                                            <button class="btn btn-info btn-sm rounded-pill"
                                                wire:click="editSubscription({{ $subscription->id }})">
                                                <span class="btn-icon icofont-ui-edit "> Edit</span>
                                            </button>
                                            {{-- <button class="btn btn-error btn-sm btn-square rounded-pill">
                                                <span class="btn-icon icofont-ui-delete"></span>
                                            </button> --}}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8" align="center">No Subscription Found</td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $subscriptions->links() }}
                    </div>
                </div>
            </div>
            <div class="add-action-box">
                <button class="btn btn-primary btn-lg btn-square rounded-pill" wire:click.prevent="addSubscription">
                    <span class="btn-icon icofont-plus"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Add appointment modals -->
    <div class="modal fade" id="modal-subscription" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($showEditModal)
                        <span> Subscription</span>
                        @else
                        <span>Add New Subscription</span>
                        @endif
                    </h5>
                </div>
                <form autocomplete="off"
                    wire:submit.prevent="{{ $showEditModal ? 'updateSubscription' : 'createSubscription' }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <select class="form-control @error('package_id') is-invalid @enderror"
                                wire:model.defer="state.package_id" id="package_id" name="package_id">
                                <option class="d-none">Select Subscription Package</option>
                                @foreach ($packages as $package)
                                <option value="{{ $package->id }}">{{ $package->name }}
                                    {{ ' (@ '.$package->monthly_cost.'.00 TZS)' }}</option>
                                @endforeach
                            </select>
                            @error('package_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <select class="form-control @error('paid_by') is-invalid @enderror"
                                wire:model.defer="state.paid_by" id="paid_by" name="paid_by">
                                <option class="d-none">Subscription Paid By</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('paid_by')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <select class="form-control @error('status') is-invalid @enderror"
                                wire:model.defer="state.status" id="status" name="status">
                                <option class="d-none">Subscription Status</option>
                                <option value="Paid">Paid </option>
                                <option value="Subscribed">Subscribed </option>
                                <option value="UnSubscribed">UnSubscribed </option>
                                <option value="Blocked">Blocked </option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('payment_ref') is-invalid @enderror" type="text"
                                wire:model.defer="state.payment_ref" id="payment_ref" name="payment_ref"
                                placeholder="Payment Reference">
                            @error('payment_ref')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('total_price') is-invalid @enderror" type="text"
                                wire:model.defer="state.total_price" id="total_price" name="total_price"
                                placeholder="Total Price">
                            @error('total_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <x-datepicker wire:model.defer="state.start_date" id="start_date" :error="'start_date'"
                                :holder="'Start Date'" />
                            @error('start_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <x-datepicker wire:model.defer="state.end_date" id="end_date" :error="'end_date'"
                                :holder="'End Date'" />
                            @error('end_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer d-block">
                        <div class="actions justify-content-between">
                            <button type="button" class="btn btn-error" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-info">
                                @if($showEditModal)
                                <span>Save Changes</span>
                                @else
                                <span>Save</span>
                                @endif
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end Add appointment modals -->
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "progressBar": true,
        }

        window.addEventListener('hide-subscription-modal', event => {
            $('#modal-subscription').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })
    });
</script>
<script>
    window.addEventListener('show-subscription-modal', event => {
        $('#modal-subscription').modal('show');
    })

    // window.addEventListener('show-delete-modal', event => {
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
