<?php

abstract class GraduateBaseController extends DController
{
    protected function beforeAction($action)
    {
        GraduateModule::registerScripts();

        return parent::beforeAction($action);
    }
}
