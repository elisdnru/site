<?php

declare(strict_types=1);

namespace app\modules\user\controllers;

use app\modules\user\forms\RemindForm;
use app\modules\user\models\User;
use yii\mail\MailerInterface;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;

/**
 * @psalm-api
 */
final class RemindController extends Controller
{
    public function actionRemind(Request $request, Session $session, MailerInterface $mailer): Response|string
    {
        $model = new RemindForm();

        if ($model->load((array)$request->post()) && $model->validate()) {
            $user = User::findOne(['email' => $model->email]);

            if ($user) {
                $password = mb_substr(md5(microtime()), 0, 10, 'UTF-8');
                $user->password_hash = $user->hashPassword($password);

                $user->save();
                $user->sendRemind($password, $mailer);
                $session->setFlash('success', 'Новые параметры отправлены на Email');
                return $this->redirect(['default/login']);
            }

            $session->setFlash('error', 'Пользователь не найден');
        }

        return $this->render('remind', [
            'model' => $model,
        ]);
    }
}
