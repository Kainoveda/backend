<!-- resources/views/emails/registration/confirmation.blade.php -->

@component('mail::message')
# Registration Confirmation

Hello {{ $user->name }},

Thank you for registering! To complete your registration, please click the button below:

@component('mail::button', ['url' => $verificationLink])
Confirm Registration
@endcomponent

If you didn't register, please ignore this email.

Thanks,
{{ config('app.name') }}
@endcomponent
