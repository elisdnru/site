<?php

namespace app\modules\portfolio\components;

use app\components\Controller;
use app\modules\portfolio\Module;

abstract class PortfolioBaseController extends Controller
{
    protected function beforeAction($action): bool
    {
        Module::registerScripts();

        return parent::beforeAction($action);
    }
}
