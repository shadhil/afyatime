@component('vendor.mail.html.message')

Hello {{ $patient['name'] }} this is to confirm that an account has been created for you as a patient for
{{ $patient['clinic'] }} which have been subscribed to AFYATIME. From now onwards you will be able to receive SMS
reminders for all your clinic appointments in the future.

Please contact us on support@afyatime.co.tz if you have any problem accessing your account.

Kind regards,<br>
AfyaTime Tanzania.
{{-- Thanks,<br> --}}
{{-- {{ config('app.name') }} --}}
@endcomponent
