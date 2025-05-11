<?php

declare(strict_types=1);

namespace app\modules\user\widgets;

use app\modules\user\forms\LoginForm;
use app\modules\user\models\User;
use BadMethodCallException;
use Override;
use Yii;
use yii\base\Widget;
use yii\web\Request;
use yii\web\User as WebUser;

final class LoginFormWidget extends Widget
{
    private WebUser $user;

    /**
     * @psalm-api
     * @param array<string, mixed> $config
     */
    public function __construct(WebUser $user, array $config = [])
    {
        parent::__construct($config);
        $this->user = $user;
    }

    #[Override]
    public function run(): string
    {
        $model = new LoginForm();
        $model->rememberMe = '1';

        if ($this->user->id) {
            $user = User::findOne($this->user->id);
        } else {
            $user = null;
        }

        $request = Yii::$app->request;

        if (!$request instanceof Request) {
            throw new BadMethodCallException('Unable to use non-web request.');
        }

        return $this->render('LoginForm', [
            'model' => $model,
            'user' => $user,
            'request' => $request,
        ]);
    }
}
