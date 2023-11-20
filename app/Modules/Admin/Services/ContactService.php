<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/12/2020
 * Time: 2:54 PM
 */

namespace App\Modules\Admin\Services;

use App\Modules\Admin\Models\ContactModel;

class ContactService extends Service{
    function __construct()
    {
        parent::__construct(new ContactModel());
    }
}