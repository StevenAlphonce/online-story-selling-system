@component('mail::message')

<p>Hello {{$user->name}}</p>

@component('mail::button',['url'=>url('verification',$user->remember_token)])
Tap to Verify 
@endcomponent

<p>You can't login and use {{config('app.name')}} services withoutverifying youe email address

Thank you</br>
{{config('app.name')}} 
@endcomponent