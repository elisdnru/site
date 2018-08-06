<?php

class DModuleAdminFilter extends CFilter
{
    protected function preFilter($filterChain)
    {
        if (!Yii::app()->moduleManager->allowed($filterChain->controller->module->id)) {
            if ($filterChain->controller->id !== 'error') {
                throw new CHttpException(403, 'Forbidden');
            }
        }

        return true;
    }
}
