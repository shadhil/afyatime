@props(['placeholder' => 'Select Options', 'id'])

<div wire:ignore>
    <select id="{{ $id }}" multiple="multiple" data-placeholder="{{ $placeholder }}" style="width: 100%;">
        {{ $slot }}
    </select>
</div>

@once
@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@endonce

@once
@push('scripts')
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
@endpush
@endonce

@push('scripts')
<script>
    $(function() {
        $('#{{ $id }}').select2({
            theme: 'bootstrap4',
        })
    })
</script>
@endpush
