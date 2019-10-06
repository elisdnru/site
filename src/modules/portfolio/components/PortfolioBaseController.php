<?php

namespace app\modules\portfolio\components;

use app\components\Controller;
use app\modules\portfolio\PortfolioModule;

abstract class PortfolioBaseController extends Controller
{
    protected function beforeAction($action)
    {
        PortfolioModule::registerScripts();

        return parent::beforeAction($action);
    }
}
