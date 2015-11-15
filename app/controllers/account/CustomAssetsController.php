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

class CustomAssetsController extends AuthorizedController
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
		
	/*	$groups = $user->getGroups();

		foreach($groups as $group)
		{
			$group = $group->name;
		}
 */
                return View::make('frontend/account/view-assets', compact('user'));
            } else {
                // Prepare the error message
                $error = Lang::get('admin/users/message.user_not_found', compact('id' ));

                // Redirect to the user management page
                return Redirect::route('users')->with('error', $error);
            }

	}

}
