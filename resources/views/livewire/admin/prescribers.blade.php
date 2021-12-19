<div class="content">
    <h2 class="content-heading">{{ $orgName }}</h2>
    <div class="block-header">
        <h3 class="block-title">Prescribers</h3>
    </div>
    <div class="row">
        <!-- Row #1 -->
        @if (sizeof($prescribers)>0)
        @foreach ($prescribers as $prescriber)
        <div class="col-md-4 col-xl-3">
            <div class="block text-center">
                <div class="block-content block-content-full block-sticky-options pt-30">
                    <div class="block-options">

                    </div>
                    <img class="img-avatar"
                        src="{{ $prescriber->profile_photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($prescriber->profile_photo) }}"
                        alt="">
                </div>
                <span>
                    <div class="block-content block-content-full block-content-sm bg-body-light">
                        <div class="font-w600 mb-5 text-primary">{{ $prescriber->first_name }} {{ $prescriber->last_name
                            }}</div>
                        <div class="font-size-sm text-muted">{{ $prescriber->type->title ?? '' }}</div>
                    </div>
                </span>
                {{-- <div class="block-content">
                    <div class="row items-push">
                        <div class="col-6">
                            <div class="mb-5"><i class="si si-users fa-2x"></i></div>
                            <div class="font-size-sm text-muted">9 Patients</div>
                        </div>
                        <div class="col-6">
                            <div class="mb-5"><i class="si si-calendar fa-2x"></i></div>
                            <div class="font-size-sm text-muted">2 Appointments</div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
        @endforeach
        @endif
        <!-- END Row #2 -->
    </div>
    <div class="float-right mb-15">
        {{ $prescribers->links('vendor.livewire.bootstrap') }}
    </div>

</div>
<!-- end Add appointment modals -->


@push('scripts')
<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "progressBar": true,
        }

        window.addEventListener('hide-prescriber-modal', event => {
            $('#modal-prescriber').modal('hide');
            if(event.detail.message != 'none'){
                toastr.success(event.detail.message, 'Success!');
            }
        })

        window.addEventListener('show-error-toastr', event => {
            toastr.error(event.detail.message, 'Error!');
        })
    });
</script>
<script>
    window.addEventListener('show-prescriber-modal', event => {
        $('#modal-prescriber').modal('show');
    })

    window.addEventListener('show-delete-modal', event => {
        $('#delete-modal').modal('show');
    })

    window.addEventListener('hide-delete-modal', event => {
        $('#delete-modal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })

    window.addEventListener('show-title-modal', event => {
        $('#title-role-modal').modal('show');
    })

    window.addEventListener('hide-title-modal', event => {
        $('#title-role-modal').modal('hide');
    })

        // window.addEventListener('hide-prescriber-modal', event => {
        //     $('#add-admin').modal('hide');
        // })
</script>
<script>
    // $('#gender').selectpicker({
    //         style: '',
    //         styleBase: 'form-control',
    //         tickIcon: 'icofont-check-alt'
    //     });

    //     $('#prescriber_type').selectpicker({
    //         style: '',
    //         styleBase: 'form-control',
    //         tickIcon: 'icofont-check-alt'
    //     });


    //     window.livewire.on('setGender', gender => {
    //         $('#gender').selectpicker('val', gender);
    //     });

    //     window.livewire.on('setPrescriberType', type => {
    //         $('#prescriber_type').selectpicker('val', gender);
    //     });
</script>
@endpush
