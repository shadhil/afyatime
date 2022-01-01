@component('vendor.mail.html.message')

Hello! {{ $details['name'] }}'s subscriptions has been renewed successfully under the package {{ $details['package'] }}.
Ths subscription will end on
{{ $details['end_date'] }}



Please contact us on support@afyatime.com if you have any problem accessing your account.

Kind regards,<br>
AfyaTime Tanzania.
{{-- Thanks,<br> --}}
{{-- {{ config('app.name') }} --}}
@endcomponent
