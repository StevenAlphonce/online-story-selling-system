@component('mail::message')

<p>Hello {{$user->name}}</p>

@component('mail::button',['url'=>url('reset-password',$user->remember_token)])
Reset your password
@endcomponent

<p>Your account has request password reset</p>

Thank you</br>
{{config('app.name')}} 
@endcomponent