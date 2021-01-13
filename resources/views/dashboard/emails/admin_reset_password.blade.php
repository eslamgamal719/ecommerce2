@component('mail::message')
# Reset Account

Welcome {{$data['admin']->name}} <br>

@component('mail::button', ['url' => aurl('reset/password/' . $data['token'])])
Click here to reset password
@endcomponent

Or<br>
copy this link
<a href="{{aurl('reset/password/' . $data['token'])}}">{{aurl('reset/password/' . $data['token'])}}</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
