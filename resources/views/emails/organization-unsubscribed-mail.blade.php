@component('vendor.mail.html.message')

Hello! {{ $details['name'] }} your organization subscription is ended on {{ $details['date'] }}. You can't use
appointment features in our app.


Please contact us on support@afyatime.com if you have any problem accessing your account.

Kind regards,<br>
AfyaTime Tanzania.
{{-- Thanks,<br> --}}
{{-- {{ config('app.name') }} --}}
@endcomponent
