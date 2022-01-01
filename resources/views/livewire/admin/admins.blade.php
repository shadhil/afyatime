<div class="content">

    <div class="block">
        <div class="block-header block-header-default">
            {{-- <h3 class="block-title">All Organizations</h3> --}}
            @if (Auth::user()->status == '2')
            <button type="button" class="btn btn-alt-primary" wire:click="addAdmin">
                <i class="fa fa-plus mr-5"></i>New Admin
            </button>
            @endif


        </div>
        <div class="block-content">

            <table class="table table-striped table-vcenter">
                <thead>
                    <tr>
                        <th width="25%"> Name</th>
                        <th class="text-center" width="25%">Email</th>
                        <th class="d-none d-md-table-cell text-center">Phone Number</th>
                        @if (Auth::user()->status == '2')
                        <th class="text-center" style="width: 100px;">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if (sizeof($admins)>0)
                    @foreach ($admins as $admin)
                    <tr>
                        <td class="font-w700" width="25%">
                            {{ $admin->name }}
                        </td>
                        <td class="text-center" width="25%">
                            {{ $admin->email }}
                        </td>
                        <td class="d-none d-md-table-cell text-center">
                            {{ $admin->phone_number }}
                        </td>
                        @if (Auth::user()->status == '2')
                        <td class="text-center">
                            <div class="btn-group">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                        title="Visited" wire:click.prevent="editdmin({{ $admin }})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </div>
                                @if ($admin->status != '2')
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="View"
                                    wire:click.prevent="confirmAdminRemoval({{ $admin->id }})">
                                    <i class=" fa fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="float-right">
        {{ $admins->links('vendor.livewire.bootstrap') }}
    </div>

    <div class="modal fade" id="add-admin" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">
                            @if($showEditModal)
                            <span>Edit Admin</span>
                            @else
                            <span>Add Admin</span>
                            @endif
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form wire:submit.prevent="{{ $showEditModal ? 'updateAdmin' : 'createAdmin' }}">

                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        wire:model.defer="state.name" id="name" name="name"
                                        placeholder="Enter admin's full name..">
                                    @error('name')
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
                                            wire:model.defer="state.phone_number" id="phone_number" name="phone_number"
                                            placeholder="Enter admin's phone number..">
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
                                            wire:model.defer="state.email" id="email" name="email"
                                            placeholder="Enter admin's email..">
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
                                <label class="col-12" for="location">Password</label>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            wire:model.defer="state.password" id="password" name="password"
                                            placeholder="Enter your password..">
                                        @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12" for="location">Confirm Password</label>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            wire:model.defer="state.password_confirmation" id="passwordConfirmation"
                                            name="password_confirmation" placeholder="Confirm your password..">
                                        @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
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

    <!-- Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Delete Admin</h5>
                </div>

                <div class="modal-body">
                    <h4>Are you sure you want to delete this admin?</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fa fa-times mr-1"></i>
                        Cancel</button>
                    <button type="button" wire:click.prevent="deleteAdmin" class="btn btn-danger"><i
                            class="fa fa-trash mr-1"></i>Delete Admin</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/icofont.min.css') }}">
@endpush
@push('scripts')
<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "progressBar": true,
        }

        window.addEventListener('hide-admin-modal', event => {
            $('#add-admin').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })

    });
</script>
<script>
    window.addEventListener('show-admin-modal', event => {
            $('#add-admin').modal('show');
        })

        window.addEventListener('show-delete-modal', event => {
            $('#confirmationModal').modal('show');
        })

        window.addEventListener('hide-delete-modal', event => {
            $('#confirmationModal').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })

        // window.addEventListener('hide-admin-modal', event => {
        //     $('#add-admin').modal('hide');
        // })
</script>
@endpush
