@extends('backend/layouts/default')

@section('title0')
	{{{ $accessory->name}}}
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

<div class="table-responsive">
    </div>
</div>





@stop
