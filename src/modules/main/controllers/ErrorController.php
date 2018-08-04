<?php

Yii::import('application.modules.page.models.Page');

class ErrorController extends DController
{
	public function actionIndex()
	{
        if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
            {
	        	$this->render('index', array(
                    'error'=>$error,
                    'page'=>$this->loadPage()
                ));
                Yii::app()->end();
            }
	    }
        else
            throw new CHttpException(404, 'Страница не найдена');
	}

    /**
     * @return CActiveRecord
     */
    protected function loadPage()
    {
        if (!$page = Page::model()->findByAlias('error')){
            $page = new Page();
        }
        return $page;
    }
}