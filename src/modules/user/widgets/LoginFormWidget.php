<?php

namespace app\modules\user\widgets;

use app\modules\user\forms\LoginForm;
use app\modules\user\models\User;
use CWidget;
use Yii;

class LoginFormWidget extends CWidget
{
    public $tpl = 'LoginForm';

    public function run(): void
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
