@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
View Assets for  {{{ $user->fullName() }}} ::
@parent
@stop

{{-- Account page content --}}
@section('content')

<div class="row user-profile">
            <!-- header -->
            <div class="row header">
                <div class="col-md-8">
                    @if ($user->avatar)
                        <img src="/uploads/avatars/{{{ $user->avatar }}}" class="avatar img-circle">
                    @else
                     <img src="/uploads/avatar.jpg" class="avatar img-circle">
			@endif
                    <h3 class="name">{{{ $user->fullName() }}}</h3>
                    <span class="area">{{{ $user->jobtitle }}}
                        </span>
                </div>
        	</div>

            <div class="row profile">

                    <!-- bio, new note & orders column -->
                    <div class="col-md-10 bio">
                        <div class="profile-box">

                        @if ($user->deleted_at != NULL)

                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    <i class="fa fa-exclamation-circle"></i>
                                    <strong>Warning: </strong>
                                     This user has been deleted. You will have to restore this user to edit them or assign them new assets.
                                </div>
                            </div>

                        @endif


                            <!-- checked out assets table -->
                            @if (count($user->assets) > 0)
                            
                            <h4>Assets Checked Out to You</h4>
                            <br>
							<div class="table-responsive">
							<table class="display">
                                <thead>
                                    <tr>
                                        <th class="col-md-6">Asset Name</th>
                                        <th class="col-md-2">Asset Tag</th>
					<th class="col-md-2">Due Date</th>
					<th class='col-me-2'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($due_dates as $asset)
                                    <tr>
                                        <td><a href="{{ route('view-item', $asset->id) }}">{{{ $asset->name}}}</a></td>
                                        <td>{{{ $asset->asset_tag }}}</td>
					<td>@if(isset($asset->expected_checkin))
						{{{$asset->expected_checkin}}}
					    @else
						End of Quarter
					   @endif
					</td>
					<td> <a href="{{ route('account/request-extension', $asset->id) }}" class="btn btn-info btn-sm" title="Request Extension">Request Extension</a>
					</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
							</div>
                            @endif
				
				 <!-- checked out licenses table -->
                            @if (count($user->accessories) > 0)
				<br><br>
                            <h4>Accessories Checked Out to You</h4>
                            <br>
                                                        <div class="table-responsive">
                                                        <table class="display">
                                <thead>
                                    <tr>
                                        <th class="col-md-3">Accessory Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->accessories as $accessory)
                                    <tr>
                                        <td>{{{ $accessory->name }}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                                                        </div>
                            @endif

                                   <!-- checked out consumables table -->
                            @if (count($user->consumables) > 0)
                                <br><br>
                            <h4>Consumables Checked Out to You</h4>
                            <br>
                                    <div class="table-responsive">
                                                        <table class="display">
                                <thead>
                                    <tr>
                                        <th class="col-md-3">Consumable Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->consumables as $consumable)
                                    <tr>
                                        <td>{{{ $consumable->name }}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                                                        </div>
                            @endif

				<!-- checked out assets table -->
                            @if (count($user->licenses) > 0)
                            <br><br>
                            <h4>Licenses, Access, and Training</h4>
                            <br>
                            <div class="table-responsive">
							<table class="display">                                
								<thead>
                                    <tr>
                                        <th class="col-md-4">Name</th>
                                        <th class="col-md-4">Serial</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->licenses as $license)
                                    <tr>
                                        <td>{{{ $license->name }}}</td>
                                        <td>{{{ $license->serial }}}</td>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            @endif




                            <!-- checked out assets table -->
                            <br><br>
                            <h4>History </h4>
                            <br>
                            @if (count($user->userlog) > 0)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-md-2">Date</th>
                                        <th class="col-md-2"><span class="line"></span>Action</th>
					<th class="col-md-4"><span class="line"></span>Asset Name</th>
                                        <th class="col-md-2"><span class="line"></span>Asset Tag</th>
                                        <th class="col-md-2"><span class="line"></span>Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->userlog as $log)
                                    <tr>
                                        <td>{{{ $log->created_at }}}</td>
                                        <td>{{{ $log->action_type }}}</td>
					 <td>
					@if ((isset($log->assetlog->name)) && ($log->assetlog->deleted_at==''))
                                            {{{ $log->assetlog->name }}}
					@elseif ((isset($log->accessorylog->name)) && ($log->accessorylog->deleted_at==''))
						{{{ $log->accessorylog->name }}}
					@elseif ((isset($log->consumablelog->name)) && ($log->consumablelog->deleted_at==''))
                                                {{{ $log->consumablelog->name }}}
					@elseif ((isset($log->licenselog->name)) && ($log->licenselog->deleted_at==''))
                                                {{{ $log->licenselog->name }}}
					@endif
					</td>
                                        <td>
                                        @if ((isset($log->assetlog->asset_tag)) && ($log->assetlog->deleted_at==''))
                                            {{{ $log->assetlog->asset_tag }}}
					@elseif ((isset($log->accessorylog->name)) && ($log->accessorylog->deleted_at==''))
						 Accessory 
                                        @elseif ((isset($log->consumablelog->name)) && ($log->consumablelog->deleted_at==''))
                                                Consumable
                                        @elseif ((isset($log->licenselog->name)) && ($log->licenselog->deleted_at==''))
                                                License
					@endif
                                        </td>
                                        <td>{{{ $log->adminlog->fullName() }}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif

                        </div>
                    </div>

@stop

