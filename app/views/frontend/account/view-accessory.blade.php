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
	@if ( $accessory->category->name  != NULL)
                Category: {{{ $accessory->category->name}}}<br>
        @endif
	@if ( $accessory->qty  != NULL)
                Total Quantity: {{{ $accessory->qty}}}<br>
        @endif
	@if ( $accessory->numRemaining()  != NULL)
                Number Remaining: {{{ $accessory->numRemaining()}}}<br>
        @endif
    </div>
</div>
<br><Br>
<img src="{{ Config::get('app.url') }}/img_accessories/{{$accessory->id}}.jpg" width=300 />


@stop
