<div>
    <div class="main-content-wrap">
        <header class="page-header">
            <h1 class="page-title">Prescriber Type</h1>
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
                                    <th scope="col">Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($prescriberTypes as $prescriberType)
                                <tr>
                                    <td><strong>{{ $i }}.</strong></td>
                                    <td>
                                        <div class="text-nowrap">{{ $prescriberType->title }}</div>
                                    </td>
                                    <td>
                                        <div class="text-muted text-nowrap">{{ $prescriberType->initial ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="actions text-nowrap">
                                            <button class="btn btn-info btn-sm btn-square rounded-pill"
                                                wire:click.prevent="editPrsecriberType({{ $prescriberType }})">
                                                <span class="btn-icon icofont-ui-edit"></span>
                                            </button>
                                            <button class="btn btn-error btn-sm btn-square rounded-pill"
                                                wire:click.prevent="confirmPrescriberTypeRemoval({{ $prescriberType->id }})">
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
                    {{ $prescriberTypes->links() }}


                </div>
            </div>
            <div class="add-action-box">
                <button class="btn btn-primary btn-lg btn-square rounded-pill" wire:click.prevent="addPrescriberType">
                    <span class="btn-icon icofont-plus"></span>
                </button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-prescriberType" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
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
                <form autocomplete="off"
                    wire:submit.prevent="{{ $showEditModal ? 'updatePrescriberType' : 'createPrescriberType' }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control flatpickr-input @error('title') is-invalid @enderror" type="text"
                                placeholder="Prescriber Title" wire:model.defer="state.title" id="title" required>
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input class="form-control flatpickr-input" type="text" placeholder="Title's Initial"
                                wire:model.defer="state.initial" id="initial">
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
                    <button type="button" wire:click.prevent="deletePrescriberType" class="btn btn-danger"><i
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

        window.addEventListener('hide-prescriberType-modal', event => {
            $('#add-prescriberType').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })

    });
</script>
<script>
    window.addEventListener('show-prescriberType-modal', event => {
            $('#add-prescriberType').modal('show');
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
