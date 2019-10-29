<?php

namespace app\modules\user\widgets;

use app\modules\user\forms\LoginForm;
use app\modules\user\models\User;
use Yii;
use yii\base\Widget;

class LoginFormWidget extends Widget
{
    public $tpl = 'LoginForm';

    public function run()
    {
        $model = new LoginForm();
        $model->rememberMe = true;

        if ($post = Yii::$app->request->post('LoginForm')) {
            $model->attributes = $post;

            if ($model->validate() && $model->login()) {
                return Yii::$app->controller->refresh();
            }
        }

        if (Yii::$app->user->id) {
            $user = User::findOne(Yii::$app->user->id);
        } else {
            $user = null;
        }

        return $this->render($this->tpl, [
            'model' => $model,
            'user' => $user,
        ]);
    }
}
