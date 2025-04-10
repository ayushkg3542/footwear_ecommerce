@component('mail:message')

<h2>Hello {{ $user->name }},</h2>
<p>Thanks for registering. Please verify your email by clicking the link below:</p>
<p>
    <a href="{{ url('/verify-email/' . $user->remember_token) }}">Verify Email</a>
</p>
@endcomponent
