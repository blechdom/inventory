@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')

 {{{ $category->name }}}

@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
       <h3>@yield('title')</h3>
    </div>
</div>


<div class="row form-wrapper">

@if ($accessories->count() > 0)
<div class="table-responsive">
<table id="example">

    <thead>
        <tr role="row">
            	<th class="col-md-5" bSortable="true">@lang('admin/accessories/table.title')</th>
 		<th class="col-md-3" bSortable="true">Thumbnail</th>
 		<th class="col-md-2" bSortable="true">@lang('admin/accessories/general.total')</th>
        	 <th class="col-md-2" bSortable="true">@lang('admin/accessories/general.remaining')</th>
	</tr>
    </thead>
<tbody>
      @foreach ($accessories as $accessory)
        <tr>
  	<td><a href="{{ route('view-accessory', $accessory->id) }}">{{{ $accessory->name }}}</a></td>
        <td><a href="{{ route('view-accessory', $accessory->id) }}"><img src="{{ Config::get('app.url') }}/img_accessories/{{$accessory->id}}.jpg" height=50px /></a></td>
	  <td>{{{ $accessory->qty }}} </td>
        <td>{{{ $accessory->numRemaining() }}}</td>
        </tr>
        @endforeach


</tbody>
</table>
</div>
@else
<div class="col-md-9">
    <div class="alert alert-info alert-block">
        <i class="fa fa-info-circle"></i>
        @lang('general.no_results')
    </div>
</div>

</div>
@endif
</div>


@stop
