<?php

class DefaultController extends DController
{
    public function actions()
    {
        return array(
            'captcha'=>array(
                'class'=>'DCaptchaAction',
            ),
        );
    }

    public function actionIndex()
    {
        $form = new CallmeForm();

        if(isset($_POST['CallmeForm']))
        {
            $form->attributes = $_POST['CallmeForm'];
            if($form->validate())
            {
                $callme = new Callme;
                $callme->attributes = $_POST['CallmeForm'];

                if ($callme->save()){

                    $callme->sendEmail();

                    Yii::app()->user->setFlash('contactForm','Ваш запрос принят');
                    Yii::app()->controller->refresh();
                }
            }
        }

        $this->render('index' ,array(
            'model'=>$form,
        ));
    }

}
