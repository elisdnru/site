<?php

declare(strict_types=1);

namespace app\modules\user\controllers\admin;

use app\components\AdminController;
use app\modules\user\forms\admin\EditForm;
use app\modules\user\forms\admin\UserSearch;
use app\modules\user\models\User;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * @psalm-api
 */
final class UserController extends AdminController
{
    public function actionIndex(Request $request): string
    {
        $model = new UserSearch();
        $dataProvider = $model->search($request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionUpdate(int $id, Request $request): Response|string
    {
        $user = $this->loadModel($id);

        $form = new EditForm($user);

        if ($form->load((array)$request->post())) {
            $form->avatar = UploadedFile::getInstance($form, 'avatar');
            if ($form->validate()) {
                $user->username = $form->username;
                $user->email = $form->email;
                $user->firstname = $form->firstname;
                $user->lastname = $form->lastname;
                $user->site = $form->site;
                $user->role = $form->role;
                if ($form->avatar) {
                    $user->avatar = $form->avatar;
                }
                $user->del_avatar = (bool)$form->del_avatar;
                $user->save();
                return $this->redirect(['view', 'id' => $user->id]);
            }
        }
        return $this->render('update', [
            'user' => $user,
            'model' => $form,
        ]);
    }

    public function actionDelete(int $id, Request $request): ?Response
    {
        $model = $this->loadModel($id);
        $model->delete();

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionView(int $id): string
    {
        $model = $this->loadModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    private function loadModel(int $id): User
    {
        $model = User::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
