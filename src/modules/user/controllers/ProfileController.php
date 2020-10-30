<?php

namespace app\modules\user\controllers;

use app\components\Controller;
use app\modules\user\forms\PasswordForm;
use app\modules\user\forms\ProfileForm;
use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

class ProfileController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionEdit()
    {
        $user = $this->loadModel();

        $form = ProfileForm::fromUser($user);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $user->firstname = $form->firstname;
            $user->lastname = $form->lastname;
            $user->site = $form->site;
            if ($avatar = UploadedFile::getInstance($form, 'avatar')) {
                $user->avatar = $avatar;
            }
            $user->del_avatar = (bool)$form->del_avatar;
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Профиль сохранён.');
                return $this->redirect(['view', 'id' => $user->id]);
            }
            $form->addErrors($user->getErrors());
            $user->refresh();
        }

        return $this->render('edit', [
            'user' => $user,
            'model' => $form,
        ]);
    }

    public function actionPassword()
    {
        $user = $this->loadModel();

        $form = PasswordForm::fromUser($user);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $user->password_hash = $user->hashPassword($form->password);
            if ($user->save(false)) {
                Yii::$app->session->setFlash('success', 'Пароль сохранён.');
                return $this->redirect(['view', 'id' => $user->id]);
            }
        }

        return $this->render('password', [
            'model' => $form,
        ]);
    }

    public function actionView(): string
    {
        $user = $this->loadModel();
        return $this->render('view', [
            'user' => $user,
        ]);
    }

    private function loadModel(): User
    {
        $user = User::findOne(Yii::$app->user->id);
        if ($user === null) {
            throw new ForbiddenHttpException('Войдите или зарегистрируйтесь');
        }
        return $user;
    }
}
