<?php

DUrlRulesHelper::import('userphoto');
Yii::import('application.modules.userphoto.models.*');

class UserPhotosWidget extends DWidget
{
    public $tpl = 'default';
    public $class = 'photos';

    public $user;

    public function run()
    {
        $photos = UserPhoto::model()->user($this->user->id)->findAll();

        $model = new UserPhoto();
        $model->user_id = Yii::app()->user->id;

        $this->render('UserPhotos/' . $this->tpl, array(
            'photos'=>$photos,
            'model'=>$model,
            'user'=>$this->user,
            'class'=>$this->class,
        ));
    }
}
