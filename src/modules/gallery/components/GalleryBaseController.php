<?php

abstract class GalleryBaseController extends DController
{
    protected function beforeAction($action)
    {
        GalleryModule::registerScripts();

        return parent::beforeAction($action);
    }
}
