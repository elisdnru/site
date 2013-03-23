<?php

Yii::import('portfolio.components.PortfolioHelper');

abstract class PortfolioBaseController extends DController
{
    protected function beforeAction($action)
    {
        PortfolioModule::registerScripts();

        return parent::beforeAction($action);
    }
}
