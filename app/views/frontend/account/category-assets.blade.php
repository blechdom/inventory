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

@if ($assets->count() > 0)
<div class="table-responsive">
<table id="example">

    <thead>
        <tr role="row">
	  <th class="col-md-2" bSortable="false">Thumbnail</th>
            <th class="col-md-4" bSortable="true">@lang('admin/hardware/table.asset_model')</th>
  <th class="col-md-2" bSortable="true">@lang('general.manufacturer')</th>
<th class="col-md-2" bSortable="true">@lang('admin/hardware/table.asset_tag')</th>
<th class="col-md-2" bSortable="true">@lang('admin/hardware/table.status')</th>
</tr>
   </thead>
	<tbody>
	

      @foreach ($assets as $asset)
	@if ($asset->requestable=='1')
        <tr>
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
        </tr>
	@endif
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
