<?php

class DefaultController extends DController
{
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'DCaptchaAction',
            ],
        ];
    }
}
