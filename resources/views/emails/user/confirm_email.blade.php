@component('mail::message')
# Confirm Email

Hi {{ $user->first_name }},

Your account was created. Please confirm your email to continue.

@component('mail::button', ['url' => url('/user/verify/' . $user->verifyUser->token)])
Confirm Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
