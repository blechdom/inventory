@extends('emails/layouts/default')

@section('content')
<p>Hello DANM Equipment Checkout,
</p>
<p>
 {{{ $first_name }}} {{{ $last_name }}}
has requested the following license:</p> 

<table>
	<tr>
		<td style="background-color:#ccc">
			License Name:
		</td>
		<td>
			<strong>{{{ $item_name }}}</strong>
		</td>
	</tr>
	@if ($item_tag)
		<tr>
			<td style="background-color:#ccc">
				Asset Tag:
			</td>
			<td>
				<strong>{{{ $item_tag }}}</strong>
			</td>
		</tr>
	@endif
</table>
<p>You can contact {{{ $first_name }}} {{{ $last_name }}} at {{{ $email }}}.</p>

<p>love, {{{ Setting::getSettings()->site_name }}}</p>
@stop
