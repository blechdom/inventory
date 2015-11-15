<?php namespace Controllers\Account;

use AuthorizedController;
use Input;
use Lang;
use Accessory;
use Redirect;
use Setting;
use DB;
use Sentry;
use Str;
use Validator;
use View;
use User;
use Actionlog;
use Mail;
use Datatable;
use Slack;
use Config;

class FrontendAccessoriesController extends AuthorizedController
{
    /**
     * Show a list of all the accessories.
     *
     * @return View
     */

    public function getFrontendIndex()
    {
        return View::make('frontend/account/accessory-view');
    }

    /**
     * Accessory create.
     *
     * @return View
     */


}
