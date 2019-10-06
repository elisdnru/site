<?php

namespace app\modules\user\widgets;

use app\components\module\UrlRulesHelper;
use app\components\widgets\Widget;
use app\modules\user\models\LoginForm;
use app\modules\user\models\User;
use Yii;

UrlRulesHelper::import('user');
UrlRulesHelper::import('users');

class LoginFormWidget extends Widget
{
    public $tpl = 'LoginForm';

    public function run()
    {
        $model = new LoginForm();
        $model->rememberMe = true;

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
