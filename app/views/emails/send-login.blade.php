@extends('emails/layouts/default')

@section('content')
<p>Hello {{{ $first_name }}},</p>

<p>An account has been created for you on the new <a href="{{ Config::get('app.url') }}">DANM {{{ Setting::getSettings()->site_name }}} website.</a></p>

<p>URL: <a href="{{ Config::get('app.url') }}">{{ Config::get('app.url') }}</a><br>
<br>Login: {{{ $username }}} <br>
Password: {{{ $password }}}
</p>
<p>Please change your password when you first log in!</p>
<p>love,</p>

<p>{{{ Setting::getSettings()->site_name }}}</p>

<p> <img src="http://danmnet.ucsc.edu/uploads/avatar.jpg" class="avatar img-circle" alt="Check it out!"></p>
@stop
