<!-- resources/views/emails/approval/notification.blade.php -->

@component('mail::message')
# Artist Registration Status

Hello {{ $user->name }},

@if($status === 'approved')
Congratulations! Your artist account has been approved. You can now start showcasing your talent on our platform.
@elseif($status === 'declined')
We regret to inform you that your artist account has been declined. If you have any questions, please contact us.
@endif

@if($status === 'approved')
@component('mail::button', ['url' => $dashboardLink])
Go to Dashboard
@endcomponent
@endif

Thanks,
{{ config('app.name') }}
@endcomponent
