@component('vendor.mail.html.message')

Hello! {{ $details['name'] }} your organization have been blocked to use AfyaTime from
{{ $details['date'] }}


Please contact us on support@afyatime.co.tz if you have any problem accessing your account.

Kind regards,<br>
AfyaTime Tanzania.
{{-- Thanks,<br> --}}
{{-- {{ config('app.name') }} --}}
@endcomponent
