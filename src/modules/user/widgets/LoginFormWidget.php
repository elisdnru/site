<?php

namespace app\modules\user\widgets;

use app\components\module\DUrlRulesHelper;
use DWidget;
use LoginForm;
use User;
use Yii;

DUrlRulesHelper::import('user');
DUrlRulesHelper::import('users');

class LoginFormWidget extends DWidget
{
    public $tpl = 'LoginForm';

    public function run()
    {
        $model = new LoginForm();
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];

            if ($model->validate() && $model->login()) {
                Yii::app()->controller->refresh();
            }
        }

        if (Yii::app()->user->id) {
            $user = User::model()->findByPk(Yii::app()->user->id);
        } else {
            $user = null;
        }

        $this->render($this->tpl, [
            'model' => $model,
            'user' => $user,
        ]);
    }
}
