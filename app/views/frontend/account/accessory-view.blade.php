@extends('backend/layouts/default')

@section('title0')
            @lang('general.accessories')
@stop

{{-- Page title --}}
@section('title')
    @yield('title0') :: @parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
       <h3>@yield('title0')</h3>
    </div>
</div>


<div class="table-responsive">

@if ($accessories->count() > 0)
<table id="example">

    <thead>
        <tr role="row">
	 <th class="col-md-3" bSortable="true">@lang('admin/accessories/general.accessory_category')</th>
            	<th class="col-md-5" bSortable="true">@lang('admin/accessories/table.title')</th>
 		<th class="col-md-2" bSortable="true">@lang('admin/accessories/general.total')</th>
        	 <th class="col-md-2" bSortable="true">@lang('admin/accessories/general.remaining')</th>
	</tr>
    </thead>
<tbody>
      @foreach ($accessories as $accessory)
        <tr>
	<td>{{{ $accessory->category->name }}}</td>
  	<td>{{{ $accessory->name }}}</td>
        <td>{{{ $accessory->qty }}} </td>
        <td>{{{ $accessory->numRemaining() }}}</td>
        </tr>
        @endforeach


</tbody>
</table>
@endif
</div>


@stop
