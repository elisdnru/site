<?php

namespace app\modules\user\widgets;

use app\modules\user\forms\LoginForm;
use app\modules\user\models\User;
use yii\base\Widget;
use yii\web\User as WebUser;

class LoginFormWidget extends Widget
{
    private WebUser $user;

    public function __construct(WebUser $user, array $config = [])
    {
        parent::__construct($config);
        $this->user = $user;
    }

    public function run(): string
    {
        $model = new LoginForm();
        $model->rememberMe = true;

        if ($this->user->id) {
            $user = User::findOne($this->user->id);
        } else {
            $user = null;
        }

        return $this->render('LoginForm', [
            'model' => $model,
            'user' => $user,
        ]);
    }
}
