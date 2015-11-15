<?php namespace Controllers\Account;

use AuthorizedController;
use Input;
use Redirect;
use Sentry;
use Validator;
use Location;
use View;
use Asset;
use Actionlog;
use Lang;
use Accessory;
use Consumable;
use License;
use DB;
use Mail;
use Slack;
use Setting;
use Config;

class ViewAssetsController extends AuthorizedController
{
    /**
     * Redirect to the profile page.
     *
     * @return Redirect
     */
    public function getIndex()
    {
    	$user = Sentry::getUser();


            if (isset($user->id)) {

		$groups = $user->getGroups();

                foreach($groups as $group)
                {
                        $group = $group->name;
                }

		$due_dates = DB::table('assets')
			->join('asset_logs', 'assets.id', '=', 'asset_logs.asset_id')
			->select('assets.id', 'assets.name', 'assets.asset_tag', 'assets.assigned_to', 'assets.model_id', 'asset_logs.asset_id', 'asset_logs.expected_checkin', 'asset_logs.checkedout_to')
			->where('asset_logs.checkedout_to', $user->id)
			->where('assets.assigned_to', $user->id)
			->orderBy('asset_logs.expected_checkin', 'desc')
			->get();

			

                return View::make('frontend/account/view-assets', compact('user', 'group', 'due_dates'));
            } else {
                // Prepare the error message
                $error = Lang::get('admin/users/message.user_not_found', compact('id' ));

                // Redirect to the user management page
                return Redirect::route('users')->with('error', $error);
            }

	}


public function getRequestableIndex() {

	$assets = Asset::with('model','defaultLoc')->Hardware()->RequestableAssets()->get();
        return View::make('frontend/account/requestable-assets', compact('user','assets'));
 }
 public function getViewItem($assetId = null) {

  	$asset = Asset::withTrashed()->find($assetId);

	return View::make('frontend/account/view-item', compact('user','asset'));
    }
 public function getAccessoryIndex()
    { 
	 $accessories = Accessory::select(array('name','qty', 'category_id'))
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'DESC');

        $accessories = $accessories->get();


        return View::make('frontend/account/accessory-view', compact('accessories'));
    }
public function getConsumableIndex()
    {
         $consumables = Consumable::select(array('name','qty', 'category_id'))
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'DESC');

        $consumables = $consumables->get();


        return View::make('frontend/account/consumable-view', compact('consumables'));
    }
public function getLicenseIndex()
    {

        $licenses = License::select(array('name', 'id'))
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'DESC');

        $licenses = $licenses->get();


        return View::make('frontend/account/license-view', compact('licenses'));
} 
public function getFacilityIndex()
    {

        $assets = Asset::with('model','defaultLoc')->Facility()->get();
        return View::make('frontend/account/facility-view', compact('assets'));
    }

    public function getLicenseRequest($licenseId = null) {

	$user = Sentry::getUser();

	$license = License::find($licenseId);


	if (is_null($license)) {
            return Redirect::route('license-view')->with('error', Lang::get('admin/hardware/message.does_not_exist_or_not_requestable'));
        } else {

                                                $logaction = new Actionlog();
                                      $logaction->asset_id = $license->id;          //$logaction->item = $license->name;
						$logaction->asset_id = NULL;
                                                $logaction->asset_type = 'software';
                                                $logaction->user_id = $user->id;
                                                $logaction->note =  //e(Input::get('note'));
                                                $logaction->checkedout_to =  NULL;
                                                //$logaction->created_at = NULL; //date("Y-m-d h:i:s");
                                              //  $logaction->filename =  $filename;
                                               $log = $logaction->logaction('requested');






		$data['log_id'] = $logaction->id;
            $data['first_name'] = $user->first_name;
              $data['last_name'] = $user->last_name;
                $data['item_name'] = $license->name;
            $data['checkin_date'] = $logaction->created_at;
            $data['item_tag'] = 'License';
            $data['email'] = $user->email;

	if (($user) && (!Config::get('app.lock_passwords'))) { 
                Mail::send('emails.request-license', $data, function ($m) use ($user) {
                        $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                        $m->subject('Confirm License Request');
                    });
          Mail::send('emails.request-license-alert', $data, function ($m) use ($user) {
                         $m->to('kge@ucsc.edu', 'DANM EQUIPMENT CHECKOUT & INVENTORY');
            $m->subject('License Requested');
                        });
        } 
        return Redirect::route('license-view')->with('success', Lang::get('admin/hardware/message.requests.success'));
        }
    }

	public function getRequestExtension($assetId = null) {

        $user = Sentry::getUser();

        // Check if the asset exists and is requestable
if (is_null($asset = Asset::withTrashed()->find($assetId))) {
            // Redirect to the asset management page
            return Redirect::route('view-assets')->with('error', Lang::get('admin/hardware/message.does_not_exist_or_not_requestable'));
        } else {
            $logaction = new Actionlog();
            $logaction->asset_id = $asset->id;
            $logaction->asset_type = 'hardware';
            $logaction->created_at =  date("Y-m-d h:i:s");

            if ($user->location_id) {
                $logaction->location_id = $user->location_id;
            }
            $logaction->user_id = Sentry::getUser()->id;
            $log = $logaction->logaction('requested');
		$settings = Setting::getSettings();

                        if ($settings->slack_endpoint) {


                                $slack_settings = [
                                    'username' => $settings->botname,
                                    'channel' => $settings->slack_channel,
                                    'link_names' => true
                                ];

                                $client = new \Maknz\Slack\Client($settings->slack_endpoint,$slack_settings);

                                try {
                                                $client->attach([
                                                    'color' => 'good',
                                                    'fields' => [
                                                        [
                                                            'title' => 'EXTENSION REQUESTED FOR:',
                                                            'value' => strtoupper($logaction->asset_type).' asset <'.Config::get('app.url').'/hardware/'.$asset->id.'/view'.'|'.$asset->showAssetName().'> requested by <'.Config::get('app.url').'/hardware/'.$asset->id.'/view'.'|'.Sentry::getUser()->fullName().'>.'
                                                        ]

                                                    ]
                                                ])->send('Asset Extension Requested');

                                        } catch (Exception $e) {

                                        }

                        }
		$data['log_id'] = $logaction->id;
            $data['first_name'] = $user->first_name;
              $data['last_name'] = $user->last_name;
                $data['item_name'] = $asset->showAssetName();
            $data['checkin_date'] = $logaction->created_at;
            $data['item_tag'] = $asset->asset_tag;
            $data['note'] = $logaction->note;
            $data['email'] = $user->email;

           if (($user) && (!Config::get('app.lock_passwords'))) {
                Mail::send('emails.request-extension', $data, function ($m) use ($user) {
                        $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                        $m->subject('Confirm Asset Request');
                        });
                  Mail::send('emails.request-extension-alert', $data, function ($m) use ($user) {
                         $m->to('kge@ucsc.edu', 'DANM EQUIPMENT CHECKOUT');
        $m->subject('Checkout Extension Requested');
                        });
                }
                return Redirect::route('view-assets')->with('success')->with('success', Lang::get('admin/hardware/message.requestExtension.success'));
       } 


    }


    public function getRequestAsset($assetId = null) {

        $user = Sentry::getUser();

    	// Check if the asset exists and is requestable
        if (is_null($asset = Asset::RequestableAssets()->find($assetId))) {
            // Redirect to the asset management page
            return Redirect::route('requestable-assets')->with('error', Lang::get('admin/hardware/message.does_not_exist_or_not_requestable'));
        } else {

            $logaction = new Actionlog();
            $logaction->asset_id = $asset->id;
            $logaction->asset_type = 'hardware';
            $logaction->created_at =  date("Y-m-d h:i:s");

            if ($user->location_id) {
                $logaction->location_id = $user->location_id;
            }
            $logaction->user_id = Sentry::getUser()->id;
            $log = $logaction->logaction('requested');

            $settings = Setting::getSettings();

			if ($settings->slack_endpoint) {


				$slack_settings = [
				    'username' => $settings->botname,
				    'channel' => $settings->slack_channel,
				    'link_names' => true
				];

				$client = new \Maknz\Slack\Client($settings->slack_endpoint,$slack_settings);

				try {
						$client->attach([
						    'color' => 'good',
						    'fields' => [
						        [
						            'title' => 'REQUESTED:',
						            'value' => strtoupper($logaction->asset_type).' asset <'.Config::get('app.url').'/hardware/'.$asset->id.'/view'.'|'.$asset->showAssetName().'> requested by <'.Config::get('app.url').'/hardware/'.$asset->id.'/view'.'|'.Sentry::getUser()->fullName().'>.'
						        ]

						    ]
						])->send('Asset Requested');

					} catch (Exception $e) {

					}

			}
$data['log_id'] = $logaction->id;
            $data['first_name'] = $user->first_name;
              $data['last_name'] = $user->last_name;
		$data['item_name'] = $asset->showAssetName();
            $data['checkin_date'] = $logaction->created_at;
            $data['item_tag'] = $asset->asset_tag;
            $data['note'] = $logaction->note;
	    $data['email'] = $user->email;

           if (($user) && (!Config::get('app.lock_passwords'))) { 
                Mail::send('emails.request-asset', $data, function ($m) use ($user) {
                        $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                        $m->subject('Confirm Asset Request');
                	});
		  Mail::send('emails.request-asset-alert', $data, function ($m) use ($user) {
                         $m->to('kge@ucsc.edu', 'DANM EQUIPMENT CHECKOUT');
			$m->subject('Asset Requested');
                        });
		}
		return Redirect::route('requestable-assets')->with('success')->with('success', Lang::get('admin/hardware/message.requests.success'));
        }


    }



    // Get the acceptance screen
    public function getAcceptAsset($logID = null) {

	    if (is_null($findlog = Actionlog::find($logID))) {
            // Redirect to the asset management page
            return Redirect::to('account')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }

        // Asset
        if (($findlog->asset_id!='') && ($findlog->asset_type=='hardware')) {
        	$item = Asset::find($findlog->asset_id);

        // software
        } elseif (($findlog->asset_id!='') && ($findlog->asset_type=='software')) {
	        $item = License::find($findlog->asset_id);
	    // accessories
	    } elseif ($findlog->accessory_id!='') {
		   $item = Accessory::find($findlog->accessory_id);
        }

	    // Check if the asset exists
        if (is_null($item)) {
            // Redirect to the asset management page
            return Redirect::to('account')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }

        return View::make('frontend/account/accept-asset', compact('item'))->with('findlog', $findlog);




    }

    // Save the acceptance
    public function postAcceptAsset($logID = null) {


	  	// Check if the asset exists
        if (is_null($findlog = Actionlog::find($logID))) {
            // Redirect to the asset management page
            return Redirect::to('account/view-assets')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        }


        if ($findlog->accepted_id!='') {
            // Redirect to the asset management page
            return Redirect::to('account/view-assets')->with('error', Lang::get('admin/users/message.error.asset_already_accepted'));
        }

        if (!Input::has('asset_acceptance')) {
            return Redirect::to('account/view-assets')->with('error', Lang::get('admin/users/message.error.accept_or_decline'));
        }

    	$user = Sentry::getUser();
		$logaction = new Actionlog();

        if (Input::get('asset_acceptance')=='accepted') {
            $logaction_msg  = 'accepted';
            $accepted="accepted";
            $return_msg = Lang::get('admin/users/message.accepted');
        } else {
            $logaction_msg = 'declined';
            $accepted="rejected";
            $return_msg = Lang::get('admin/users/message.declined');
        }

		// Asset
        if (($findlog->asset_id!='') && ($findlog->asset_type=='hardware')) {
        	$logaction->asset_id = $findlog->asset_id;
        	$logaction->accessory_id = NULL;
        	$logaction->asset_type = 'hardware';

            if (Input::get('asset_acceptance')!='accepted') {
                DB::table('assets')
                ->where('id', $findlog->asset_id)
                ->update(array('assigned_to' => null));
            }


        // software
        } elseif (($findlog->asset_id!='') && ($findlog->asset_type=='software')) {
	        $logaction->asset_id = $findlog->asset_id;
        	$logaction->accessory_id = NULL;
        	$logaction->asset_type = 'software';

		// accessories
	    } elseif ($findlog->accessory_id!='') {
		    $logaction->asset_id = NULL;
        	$logaction->accessory_id = $findlog->accessory_id;
        	$logaction->asset_type = 'accessory';
        }

		$logaction->checkedout_to = $findlog->checkedout_to;

		$logaction->note = e(Input::get('note'));
		$logaction->user_id = $user->id;
		$logaction->accepted_at = date("Y-m-d h:i:s");
		$log = $logaction->logaction($logaction_msg);

		$update_checkout = DB::table('asset_logs')
			->where('id',$findlog->id)
			->update(array('accepted_id' => $logaction->id));
    $affected_asset=$logaction->assetlog;
    $affected_asset->accepted=$accepted;
    $affected_asset->save();

		if ($update_checkout ) {
			return Redirect::to('account/view-assets')->with('success', $return_msg);

		} else {
			return Redirect::to('account/view-assets')->with('error', 'Something went wrong ');
		}





    }




}
