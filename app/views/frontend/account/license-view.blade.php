@extends('backend/layouts/default')

@section('title0')
            @lang('general.licenses'), Access, and Training
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

  @if ($licenses->count() > 0)
  <table id="example">

    <thead>
      <tr role="row">
        <th class="col-md-5" bSortable="true">@lang('admin/licenses/table.title')</th>
	<th class="col-md-2"></th>
	   </tr>
    </thead>
    <tbody>
      @foreach ($licenses as $license)
      <tr>
  	     <td>{{{ $license->name }}}</td>
		 <td>
                <a href="{{ route('account/request-license', $license->id) }}" class="btn btn-info btn-sm" title="@lang('button.request')">@lang('button.request')</a>
            </td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endif
</div>


@stop
