@extends('emails/layouts/default')

@section('content')
<p>Hello {{{ $first_name }}},</p>


<p>You have requested a checkout extension for the following asset: 

<table>
	<tr>
		<td style="background-color:#ccc">
			Asset Name:
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
<p>An email has been sent to the DANM Technical Staff. You will be contacted soon to confirm your extension, and to schedule a new checkin date.</p>
</table>

<p>love, {{{ Setting::getSettings()->site_name }}}</p>
@stop
