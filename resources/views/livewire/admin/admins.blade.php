<div>
    <div class="main-content-wrap">
        <header class="page-header">
            <h1 class="page-title">Admins</h1>
        </header>

        <div class="page-content">

            <div class="card mb-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($admins as $admin)
                                <tr>
                                    <td><strong>{{ $i }}.</strong></td>
                                    <td>
                                        <div class="text-muted text-nowrap">{{ $admin->name }}</div>
                                    </td>
                                    <td><strong>{{ $admin->email }}</strong></td>
                                    <td>
                                        <div class="text-nowrap text-success">
                                            <i class="icofont-check-circled"></i> {{ $admin->phone_number }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="patient.html" class="btn btn-dark btn-sm btn-square rounded-pill">
                                                <span class="btn-icon icofont-external-link"></span>
                                            </a>
                                            <button class="btn btn-info btn-sm btn-square rounded-pill"
                                                wire:click.prevent="editdmin({{ $admin }})">
                                                <span class="btn-icon icofont-ui-edit"></span>
                                            </button>
                                            <button class="btn btn-error btn-sm btn-square rounded-pill">
                                                <span class="btn-icon icofont-ui-delete"></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @php $i++; @endphp
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="add-action-box">
                <button class="btn btn-primary btn-lg btn-square rounded-pill" wire:click.prevent="addAdmin">
                    <span class="btn-icon icofont-plus"></span>
                </button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-admin" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($showEditModal)
                        <span>Edit Admin</span>
                        @else
                        <span>Add New Admin</span>
                        @endif
                    </h5>
                </div>
                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateAdmin' : 'createAdmin' }}">
                    <div class="modal-body">
                        <div class="form-group avatar-box d-flex">
                            <img src="../assets/content/anonymous-400.jpg" width="40" height="40" alt=""
                                class="rounded-500 mr-4">

                            <button class="btn btn-outline-primary" type="button">
                                Select image<span class="btn-icon icofont-ui-user ml-2"></span>
                            </button>
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('name') is-invalid @enderror" type="text"
                                placeholder="Name" wire:model.defer="state.name" id="name" required>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('email') is-invalid @enderror" type="email"
                                placeholder="email" wire:model.defer="state.email" id="email">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('phone_number') is-invalid @enderror" type="text"
                                placeholder="phone number" wire:model.defer="state.phone_number" id="phoneNumber">
                            @error('phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                placeholder="password" wire:model.defer="state.password" id="password">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="password" placeholder="confirm password"
                                wire:model.defer="state.password_confirmation" id="passwordConfirmation">
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

        // window.addEventListener('hide-admin-modal', event => {
        //     $('#add-admin').modal('hide');
        // })
    </script>
    @endpush
</div>
