<?php

declare(strict_types=1);

namespace app\modules\user\controllers;

use app\modules\user\forms\PasswordForm;
use app\modules\user\forms\ProfileForm;
use app\modules\user\models\User;
use Override;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;
use yii\web\UploadedFile;
use yii\web\User as WebUser;

/**
 * @psalm-api
 */
final class ProfileController extends Controller
{
    #[Override]
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

    public function actionEdit(Request $request, Session $session, WebUser $webUser): Response|string
    {
        $user = $this->loadModel((int)$webUser->id);

        $form = new ProfileForm($user);

        if ($form->load((array)$request->post())) {
            $form->avatar = UploadedFile::getInstance($form, 'avatar');
            if ($form->validate()) {
                $user->firstname = $form->firstname;
                $user->lastname = $form->lastname;
                $user->site = $form->site;
                if ($form->avatar) {
                    $user->avatar = $form->avatar;
                }
                $user->del_avatar = (bool)$form->del_avatar;
                $user->save();
                $session->setFlash('success', 'Профиль сохранён.');
                return $this->redirect(['view', 'id' => $user->id]);
            }
        }

        return $this->render('edit', [
            'user' => $user,
            'model' => $form,
        ]);
    }

    public function actionPassword(Request $request, Session $session, WebUser $webUser): Response|string
    {
        $user = $this->loadModel((int)$webUser->id);

        $form = new PasswordForm($user);

        if ($form->load((array)$request->post()) && $form->validate()) {
            $user->password_hash = $user->hashPassword($form->password);
            $user->save();
            $session->setFlash('success', 'Пароль сохранён.');
            return $this->redirect(['view', 'id' => $user->id]);
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
