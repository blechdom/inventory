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
@if ($consumables->count() > 0)
<div class="table-responsive">

<table id="example">

    <thead>
        <tr role="row">
                <th class="col-md-5" bSortable="true">@lang('admin/consumables/table.title')</th>
<th class="col-md-3" bSortable="true">Thumbnail</th>

                <th class="col-md-2" bSortable="true">@lang('admin/consumables/general.total')</th>
                 <th class="col-md-2" bSortable="true">@lang('admin/consumables/general.remaining')</th>
        </tr>
    </thead>
<tbody>
      @foreach ($consumables as $consumable)
        <tr>
        <td><a href="{{route('view-consumable', $consumable->id)}}">{{{ $consumable->name }}}</a></td>
	<td><a href="{{route('view-consumable', $consumable->id)}}"><img src="{{ Config::get('app.url') }}/img_consumables/{{$consumable->id}}.jpg" height=50px /></a></td>
        <td>{{{ $consumable->qty }}} </td>
        <td>{{{ $consumable->numRemaining() }}}</td>
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
