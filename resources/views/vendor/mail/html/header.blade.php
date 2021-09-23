<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
            <img src="https://afyatime.co.tz/assets/img/logo.svg" class="logo" alt="Laravel Logo">
            @else
            <img src="{{ asset('assets/img/logo.svg') }}" class="logo" alt="AfyaTime">
            {{-- {{ $slot }} --}}
            @endif
        </a>
    </td>
</tr>
