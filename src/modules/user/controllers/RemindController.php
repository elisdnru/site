<?php

namespace app\modules\user\controllers;

use app\components\Controller;
use app\modules\user\forms\RemindForm;
use app\modules\user\models\User;
use Yii;
use yii\web\Request;

class RemindController extends Controller
{
    public function actionRemind(Request $request)
    {
        $model = new RemindForm();

        if ($model->load($request->post()) && $model->validate()) {
            $user = User::findOne(['email' => $model->email]);

            if ($user) {
                $password = mb_substr(md5(microtime()), 0, 10, 'UTF-8');
                $user->password_hash = $user->hashPassword($password);

                if ($user->save()) {
                    $user->sendRemind($password);
                    Yii::$app->session->setFlash('success', 'Новые параметры отправлены на Email');
                    return $this->redirect(['default/login']);
                }
            } else {
                Yii::$app->session->setFlash('error', 'Пользователь не найден');
            }
        }

        return $this->render('remind', [
            'model' => $model,

        ]);
    }
}
