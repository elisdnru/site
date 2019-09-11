<?php

use app\modules\portfolio\PortfolioModule;

abstract class PortfolioBaseController extends DController
{
    protected function beforeAction($action)
    {
        PortfolioModule::registerScripts();

        return parent::beforeAction($action);
    }
}
