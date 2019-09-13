<?php

namespace app\components;

use CController;

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public $menu = [];
    public $breadcrumbs = [];
}
