@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/categories/general.categories') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <h3>@lang('admin/categories/general.categories')</h3>
    </div>
</div>
<div class="table-responsive">
@if ($categories->count() > 0)
	<table id="example">
		<thead>
			<tr role="row">
				<th class="col-md-5" bSortable="true">@lang('general.name')</th>
				<th class="col-md-5" bSortable="true">@lang('general.type')</th>
				<th class="col-md-2" bSortable="true">@lang('general.assets')</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($categories as $category)
			@if (($category->category_type=='accessory')&&( $category->accessoriescount() > 0 ))	
				<tr>
					<td><a href="{{ route('category-view', $category->id) }}">{{{ $category->name }}}</a></td>
					<td>{{{ $category->category_type }}}</td>
					<td>
						{{{ $category->accessoriescount() }}}
					</td>
				</tr>
			 @elseif (($category->category_type=='asset') && ( $category->requestableassetscount() > 0 ))
				<tr>
                                        <td><a href="{{ route('category-view', $category->id) }}">{{{ $category->name }}}</a></td>
                                        <td>{{{ $category->category_type }}}</td>
                                        <td>
                                        	{{{ $category->requestableassetscount() }}}
					</td>
                                </tr>
                                @elseif (($category->category_type=='consumable') && ($category->consumablescount() > 0 ))
					 <tr>
                                        <td><a href="{{ route('category-view', $category->id) }}">{{{ $category->name }}}</a></td>
                                        <td>{{{ $category->category_type }}}</td>
                                        <td>
                                        {{{ $category->consumablescount() }}}
				</td>
                                </tr>
				@endif
		@endforeach
		</tbody>
	</table>
@endif
</div>
@stop
