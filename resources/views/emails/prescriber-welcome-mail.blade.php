@component('mail::message')

{{-- # {{ $details['title'] }} --}}

Hello! this is to confirm that {{ $details['name'] }} has been successfully registered as prescriber in AfyaTime web
application, under the {{ $details['organization'] }} account.

The login details have been attach in this email, for security reasons you are advised to change the password to the one
you are comfortable with and easy to remember after you logged in.

Username: {{ $details['email'] }}<br>
Password: {{ $details['password'] }}

Click the button below to go to login page and proceed.
@component('mail::button', ['url' => 'https://afyatime.co.tz/login'])
Login Now
@endcomponent


Please contact us on support@afyatime.co.tz if you have any problem accessing your account.

Kind regards,<br>
AfyaTime Tanzania.
{{-- Thanks,<br> --}}
{{-- {{ config('app.name') }} --}}
@endcomponent
