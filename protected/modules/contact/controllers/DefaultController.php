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

}
