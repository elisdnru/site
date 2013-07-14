<?php

abstract class PersonnelBaseController extends DController
{
    protected function beforeAction($action)
    {
        PersonnelModule::registerScripts();

        return parent::beforeAction($action);
    }
}
