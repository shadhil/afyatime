<div>
    <div class="main-content-wrap">
        <header class="page-header">
            <h1 class="page-title">orgType</h1>
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
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($orgTypes as $orgType)
                                <tr>
                                    <td><strong>{{ $i }}.</strong></td>
                                    <td>
                                        <div class="text-muted text-nowrap">{{ $orgType->type }}</div>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <button class="btn btn-info btn-sm btn-square rounded-pill"
                                                wire:click.prevent="editdmin({{ $orgType }})">
                                                <span class="btn-icon icofont-ui-edit"></span>
                                            </button>
                                            <button class="btn btn-error btn-sm btn-square rounded-pill"
                                                wire:click.prevent="confirmOrgTypeRemoval({{ $orgType->id }})">
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
                    {{ $orgTypes->links() }}


                </div>
            </div>
            <div class="add-action-box">
                <button class="btn btn-primary btn-lg btn-square rounded-pill" wire:click.prevent="addOrgType">
                    <span class="btn-icon icofont-plus"></span>
                </button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-orgType" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($showEditModal)
                        <span>Edit Type</span>
                        @else
                        <span>Add New Type</span>
                        @endif
                    </h5>
                </div>
                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateOrgType' : 'createOrgType' }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control flatpickr-input @error('type') is-invalid @enderror" type="text"
                                placeholder="Organization Type" wire:model.defer="state.type" id="type" required>
                            @error('type')
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

    <!-- Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Delete Org Type</h5>
                </div>

                <div class="modal-body">
                    <h4>Are you sure you want to delete this type?</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fa fa-times mr-1"></i>
                        Cancel</button>
                    <button type="button" wire:click.prevent="deleteOrgType" class="btn btn-danger"><i
                            class="fa fa-trash mr-1"></i>Delete Type</button>
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

        window.addEventListener('hide-orgType-modal', event => {
            $('#add-orgType').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })

    });
</script>
<script>
    window.addEventListener('show-orgType-modal', event => {
            $('#add-orgType').modal('show');
        })

        window.addEventListener('show-delete-modal', event => {
            $('#confirmationModal').modal('show');
        })

        window.addEventListener('hide-delete-modal', event => {
            $('#confirmationModal').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })

</script>
@endpush
</div>
