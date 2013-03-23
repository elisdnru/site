<?php

Yii::import('application.modules.page.models.Page');

class ErrorController extends DController
{
	public function actionIndex()
	{
        $page = Page::model()->find('alias = "error"');

	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
            {
	        	$this->render('index', array('error'=>$error, 'page'=>$page));
                Yii::app()->end();
            }
	    }
        else
            throw new CHttpException(404, 'Страница не найдена');
	}
}