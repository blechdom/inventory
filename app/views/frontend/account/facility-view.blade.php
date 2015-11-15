@extends('backend/layouts/default')

@section('title0')
            @lang('general.facility_inventory')
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

<div class="row form-wrapper">

@if ($assets->count() > 0)

<div class="table-responsive">
<table id="example">

    <thead>
        <tr role="row">
		<th class="col-md-2" bSortable="true">@lang('general.location')</th>
		<th class="col-md-2" bSortable="true">@lang('general.category')</th>
           	<th class="col-md-2" bSortable="false">Thumbnail</th>
            	<th class="col-md-2" bSortable="true">@lang('general.asset')</th>
		<th class="col-md-2" bSortable="true">@lang('general.model')</th>
  		<th class="col-md-1" bSortable="true">@lang('general.manufacturer')</th>            
		<th class="col-md-1" bSortable="true">@lang('admin/hardware/table.asset_tag')</th>
		<th class="col-md-1" bSortable="true">@lang('admin/hardware/table.status')</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($assets as $asset)
        <tr>
 <td>{{{ $asset->assetloc->name}}} </td>
  <td>{{{ $asset->model->category->name}}} </td>
            <td align="center" bgcolor="#FFF">
@if ( $asset->model->image  != NULL)
<a href="{{ route('view-item', $asset->id) }}"><img src="/uploads/models/{{{ $asset->model->image }}}" style="height:50px;" /></a>
@else 
<a href="{{ route('view-item', $asset->id) }}"><img src="/uploads/Toolbox-icon.png" style="height:50px;" /></a>
@endif
</td>
	<td> <a href="{{ route('view-item', $asset->id) }}">{{{ $asset->name}}}</a></td>
	<td> {{{ $asset->model->name }}} / {{{ $asset->model->modelno }}}</td>
 	<td>{{{ $asset->model->manufacturer->name}}} </td>
 	<td>{{{ $asset->asset_tag }}}</td>
	<td>

		@if (($asset->status_id ) && ($asset->status_id > 0))
                        <!-- Status Info -->
                	@if ($asset->assetstatus)
                            {{{ $asset->assetstatus->name }}}
                 	@endif
            	@endif
	</td>

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


@stop
