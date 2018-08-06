<?php

class DModuleFilter extends CFilter
{
    protected function preFilter($filterChain)
    {
        if (!Yii::app()->moduleManager->active($filterChain->controller->module->id)) {
            if ($filterChain->controller->id !== 'error') {
                throw new CHttpException(404, 'Not Found');
            }
        }

        return true;
    }
}
