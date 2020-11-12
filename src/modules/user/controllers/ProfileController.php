<?php

namespace app\modules\user\controllers;

use yii\web\Controller;
use app\modules\user\forms\PasswordForm;
use app\modules\user\forms\ProfileForm;
use app\modules\user\models\User;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\Request;
use yii\web\Session;
use yii\web\UploadedFile;
use yii\web\User as WebUser;

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

    public function actionEdit(Request $request, Session $session, WebUser $webUser)
    {
        $user = $this->loadModel((int)$webUser->id);

        $form = ProfileForm::fromUser($user);

        if ($form->load($request->post())) {
            $form->avatar = UploadedFile::getInstance($form, 'avatar');
            if ($form->validate()) {
                $user->firstname = $form->firstname;
                $user->lastname = $form->lastname;
                $user->site = $form->site;
                if ($form->avatar) {
                    $user->avatar = $form->avatar;
                }
                $user->del_avatar = (bool)$form->del_avatar;
                if ($user->save()) {
                    $session->setFlash('success', 'Профиль сохранён.');
                    return $this->redirect(['view', 'id' => $user->id]);
                }
                $form->addErrors($user->getErrors());
                $user->refresh();
            }
        }

        return $this->render('edit', [
            'user' => $user,
            'model' => $form,
        ]);
    }

    public function actionPassword(Request $request, Session $session, WebUser $webUser)
    {
        $user = $this->loadModel((int)$webUser->id);

        $form = PasswordForm::fromUser($user);

        if ($form->load($request->post()) && $form->validate()) {
            $user->password_hash = $user->hashPassword($form->password);
            if ($user->save(false)) {
                $session->setFlash('success', 'Пароль сохранён.');
                return $this->redirect(['view', 'id' => $user->id]);
            }
        }

        return $this->render('password', [
            'model' => $form,
        ]);
    }

    public function actionView(WebUser $webUser): string
    {
        $user = $this->loadModel((int)$webUser->id);
        return $this->render('view', [
            'user' => $user,
        ]);
    }

    private function loadModel(int $id): User
    {
        $user = User::findOne($id);
        if ($user === null) {
            throw new ForbiddenHttpException('Войдите или зарегистрируйтесь');
        }
        return $user;
    }
}
