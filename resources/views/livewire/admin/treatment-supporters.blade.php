<div class="content">
    <h2 class="content-heading">{{ $orgName }}</h2>
    <div class="block-header">
        <h3 class="block-title">All Treatment Supporter</h3>
        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material form-material-primary">
                    <input type="text" class="form-control" wire:model="searchTerm" wire:keydown.enter="searchSupporter"
                        name="searchTerm" placeholder="Search Supporter" wire:keydown.enter="searchSupporter">
                </div>
            </div>
        </div>
    </div>
    @if (sizeof($supporters)>0)
    <div class="row">
        @foreach ($supporters as $supporter)
        <div class="col-md-4 col-xl-3">
            <a class="block block-link-shadow" href="javascript:void(0)"
                wire:click.prevent="viewSupporter({{ $supporter->id }})">
                <div class="block-content block-content-full clearfix">
                    <div class="float-right">
                        <img class="img-avatar"
                            src="{{ $supporter->photo == null ? asset('assets/images/avatar.jpg') : asset($supporter->photo) }}"
                            alt="">
                    </div>
                    <div class="float-left mt-10">
                        <div class="font-w600 mb-5">{{ $supporter->full_name }}</div>
                        <div class="font-size-sm text-muted">{{ $supporter->patients()->count() }} Patient(s)</div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <div class="float-right mb-15">
        {{ $supporters->links('vendor.livewire.bootstrap') }}
    </div>
    @else
    <div class="row mb-15">
        <div class="col-sm-12 col-xl-12 text-center">
            No Supporter Found
        </div>
    </div>
    @endif

</div>

@push('scripts')
<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "progressBar": true,
        }

        window.addEventListener('hide-supporter-modal', event => {
            $('#modal-supporter').modal('hide');
            if(event.detail.message != 'none'){
                toastr.success(event.detail.message, 'Success!');
            }
        })
    });
</script>
<script>
    window.addEventListener('show-supporter-modal', event => {
        // alert(event.detail.hide_first);
        if (event.detail.hide_first == true ) {
            $('#view-modal').modal('hide');
            setTimeout(function(){ $('#modal-supporter').modal('show'); }, 1000);
        }else{
            $('#modal-supporter').modal('show');
        }

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
        // window.location.href = event.detail.url;
        // toastr.success(event.detail.message, 'Success!');
    })

    window.addEventListener('show-error-toastr', event => {
        toastr.error(event.detail.message, 'Error!');
    })

        // window.addEventListener('hide-supporter-modal', event => {
        //     $('#add-admin').modal('hide');
        // })
</script>
@endpush
