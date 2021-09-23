@props(['id', 'error', 'holder'])

<input {{ $attributes }} type="text"
    class="form-control rounded datetimepicker-input @error($error) is-invalid @enderror" id="{{ $id }}"
    data-toggle="datetimepicker" data-target="#{{ $id }}" placeholder="{{ $holder }}"
    onchange="this.dispatchEvent(new InputEvent('input'))" />


@push('scripts')
<script type="text/javascript">
    $('#{{ $id }}').datetimepicker({
        icons:
        {
            up: 'icon icofont-simple-up',
            down: 'icon icofont-simple-down',
            time: 'icon icofont-clock-time',
            date: 'icon icofont-calendar',
            previous: 'icon icofont-simple-left',
            next: 'icon icofont-simple-right',
            today: 'icon icofont-ui-calendar',
            clear: 'icon icofont-trash',
            close: 'icon icofont-close'
        },
    	format: 'LT'
    });
</script>
@endpush
