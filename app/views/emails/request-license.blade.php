@extends('emails/layouts/default')

@section('content')
<p>Hello {{{ $first_name }}},</p>


<p>You have requested the following license: 

<table>
	<tr>
		<td style="background-color:#ccc">
			License Name:
		</td>
		<td>
			<strong>{{{ $item_name }}}</strong>
		</td>
	</tr>
<p>An email has been sent to the DANM Technical Staff.</p>
</table>

<p>love, {{{ Setting::getSettings()->site_name }}}</p>
@stop
