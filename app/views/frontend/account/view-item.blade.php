@extends('backend/layouts/default')

@section('title0')
	{{{ $asset->name}}}
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

<h4>
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
</h4>
<br>


<div class="table-responsive">
        @if ( $asset->model->manufacturer->name  != NULL) 
		Manufacturer: {{{ $asset->model->manufacturer->name}}} <br>
	@endif
	 @if ( $asset->model->name  != NULL) 
		Model Name: {{{ $asset->model->name}}}<br>
	@endif
	@if ( $asset->model->modelno  != NULL)
		Model Number: {{{ $asset->model->modelno}}}<br>
	@endif
 	@if ( $asset->model->category->name  != NULL)
                Category: {{{ $asset->model->category->name}}} <br>
        @endif
	 @if ( $asset->asset_tag  != NULL)
                DANM ID: {{{ $asset->asset_tag }}}<br>
        @endif
	@if ( $asset->serial  != NULL)
		Serial Number: {{{ $asset->serial}}} <br>
        @endif
@if ($asset->assigned_to == 0)
	@if ( $asset->assetloc->name  != NULL)
                Location: {{{ $asset->assetloc->name }}}<br>
        @endif 
@endif
	@if ( $asset->notes  != NULL)
<br>		Notes: {{{ $asset->notes }}}<br>
	@endif
	<br>
@if (($asset->assigned_to == 0)&&( $asset->assetstatus->name !='Facility Installed'))
       <a href="{{ route('account/request-asset', $asset->id) }}" class="btn btn-info btn-sm" title="@lang('button.request')">@lang('button.request')</a> <br><Br>
@endif
    </div>
</div>


 @if ( $asset->model->image  != NULL)
	<img src="/uploads/models/{{{ $asset->model->image }}}" style="height:300px;" /><br>
@endif 



</div>

</div>



@stop
