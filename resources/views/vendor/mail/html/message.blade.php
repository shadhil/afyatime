@component('vendor.mail.html.layout')
{{-- Header --}}
@slot('header')
@component('vendor.mail.html.header', ['url' => 'https://afyatime.co.tz/assets/img/logo.svg'])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('vendor.mail.html.subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('vendor.mail.html.footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent