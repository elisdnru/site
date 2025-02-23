<?php

declare(strict_types=1);

namespace app\modules\user\controllers;

use app\components\MathCaptchaAction;
use app\modules\user\forms\RegistrationForm;
use app\modules\user\models\Access;
use app\modules\user\models\User;
use Override;
use yii\mail\MailerInterface;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;

/**
 * @psalm-api
 */
final class RegistrationController extends Controller
{
    #[Override]
    public function actions(): array
    {
        return [
            'captcha1' => MathCaptchaAction::class,
            'captcha2' => MathCaptchaAction::class,
        ];
    }

    public function actionRequest(Request $request, Session $session, MailerInterface $mailer): Response|string
    {
        $model = new RegistrationForm();

        if ($model->load((array)$request->post()) && $model->validate()) {
            $user = new User();
            $user->username = $model->username;
            $user->email = $model->email;
            $user->password_hash = $user->hashPassword($model->password);
            $user->lastname = $model->lastname;
            $user->firstname = $model->firstname;
            $user->role = Access::ROLE_USER;

            $user->save();
            $user->sendConfirm($mailer);
            $session->setFlash(
                'success',
                'Подтвердите регистрацию, проследовав по ссылке в отправленном Вам письме'
            );

            return $this->refresh();
        }

        return $this->render('request', ['model' => $model]);
    }

    public function actionConfirm(string $code, Session $session): Response|string
    {
        $user = User::findOne(['confirm' => $code]);

        if ($user) {
            $user->confirm = '';
            $user->save();
            $session->setFlash('success', 'Регистрация подтверждена');
            return $this->redirect(['default/login']);
        }
        $session->setFlash('error', 'Запись о подтверждении не найдена');

        return $this->render('confirm');
    }
}
