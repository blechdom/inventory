@extends('backend/layouts/default')

@section('title0')
            @lang('admin/hardware/general.requestable')
    @lang('general.assets')
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
<th class="col-md-2" bSortable="true">@lang('general.category')</th>
           <th class="col-md-2" bSortable="false">Thumbnail</th>
            <th class="col-md-4" bSortable="true">@lang('admin/hardware/table.asset_model')</th>
  <th class="col-md-1" bSortable="true">@lang('general.manufacturer')</th>            
<th class="col-md-1" bSortable="true">@lang('admin/hardware/table.asset_tag')</th>
<th class="col-md-1" bSortable="true">@lang('admin/hardware/table.status')</th>

            <th class="col-md-1 actions" bSortable="false">@lang('table.actions')</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($assets as $asset)
        <tr>
  <td>{{{ $asset->model->category->name}}} </td>
            <td align="center" bgcolor="#FFF">
@if ( $asset->model->image  != NULL)
<a href="{{ route('view-item', $asset->id) }}"><img src="/uploads/models/{{{ $asset->model->image }}}" style="height:50px;" /></a>
@else 
<a href="{{ route('view-item', $asset->id) }}"><img src="/uploads/Toolbox-icon.png" style="height:50px;" /></a>
@endif
</td>
	<td> <a href="{{ route('view-item', $asset->id) }}">{{{ $asset->model->name}}}</a></td>
 	<td>{{{ $asset->model->manufacturer->name}}} </td>
 	<td>{{{ $asset->asset_tag }}}</td>
	<td>

		@if (($asset->status_id ) && ($asset->status_id > 0))
                        <!-- Status Info -->
                @if ($asset->assetstatus)
                

		        @if (($asset->assetstatus->deployable=='1') && ($asset->assigned_to > 0))
                            @lang('general.deployed')
                        @else
                            {{{ $asset->assetstatus->name }}}
                        @endif

                 @endif
            @endif






	</td>
        <td>
                <a href="{{ route('account/request-asset', $asset->id) }}" class="btn btn-info btn-sm" title="@lang('button.request')">@lang('button.request')</a>
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
