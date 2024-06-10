@component('mail::message')
    <p>Hello {{ $user->name }}</p>

    <p>Your password has been changed. If you did not initiate this change,
        please reset your password immediately using the link below:</p>

    @component('mail::button', ['url' => url('reset-password', $user->remember_token)])
        Reset your password
    @endcomponent

    Thank you</br>
    {{ config('app.name') }}
@endcomponent
