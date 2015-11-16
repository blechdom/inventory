@extends('backend/layouts/default')

@section('title0')
            @lang('general.consumables')
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

@if ($consumables->count() > 0)
<table id="example">

    <thead>
        <tr role="row">
         <th class="col-md-3" bSortable="true">@lang('admin/consumables/general.consumables_category')</th>
                <th class="col-md-5" bSortable="true">@lang('admin/consumables/table.title')</th>
<th class="col-md-2" bSortable="true">@lang('admin/consumables/general.image')</th>

                <th class="col-md-2" bSortable="true">@lang('admin/consumables/general.total')</th>
                 <th class="col-md-2" bSortable="true">@lang('admin/consumables/general.remaining')</th>
        </tr>
    </thead>
<tbody>
      @foreach ($consumables as $consumable)
        <tr>
        <td>{{{ $consumable->category->name }}}</td>
        <td><a href="{{route('view-consumable', $consumable->id)}}">{{{ $consumable->name }}}</a></td>
	<td><a href="{{route('view-consumable', $consumable->id)}}"><img src="{{ Config::get('app.url') }}/img_consumables/{{$consumable->id}}.jpg" height=50px /></a></td>
        <td>{{{ $consumable->qty }}} </td>
        <td>{{{ $consumable->numRemaining() }}}</td>
        </tr>
        @endforeach


</tbody>
</table>
@endif
</div>


@stop
