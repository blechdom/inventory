@extends('backend/layouts/default')

@section('title0')
	{{{ $consumable->name}}}
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
	@if ( $consumable->category->name  != NULL)
                Category: {{{ $consumable->category->name}}}<br>
        @endif
	@if ( $consumable->qty  != NULL)
                Total Quantity: {{{ $consumable->qty}}}<br>
        @endif
	@if ( $consumable->numRemaining()  != NULL)
                Number Remaining: {{{ $consumable->numRemaining()}}}<br>
        @endif
    </div>
</div>
<br><Br>
<img src="{{ Config::get('app.url') }}/img_consumables/{{$consumable->id}}.jpg" width=300 />


@stop
