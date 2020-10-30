<?php

namespace app\modules\user\controllers\admin;

use app\modules\user\forms\admin\EditForm;
use app\modules\user\forms\UserSearch;
use app\components\AdminController;
use app\modules\user\models\User;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class UserController extends AdminController
{
    public function actionIndex(): string
    {
        $model = new UserSearch();
        $dataProvider = $model->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $user = $this->loadModel($id);

        $form = EditForm::fromUser($user);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $user->username = $form->username;
            $user->email = $form->email;
            $user->firstname = $form->firstname;
            $user->lastname = $form->lastname;
            $user->site = $form->site;
            $user->role = $form->role;
            if ($avatar = UploadedFile::getInstance($form, 'avatar')) {
                $user->avatar = $avatar;
            }
            $user->del_avatar = (bool)$form->del_avatar;
            if ($user->save()) {
                return $this->redirect(['view', 'id' => $user->id]);
            }
            $form->addErrors($user->getErrors());
        }
        return $this->render('update', [
            'user' => $user,
            'model' => $form,
        ]);
    }

    public function actionDelete(int $id): ?Response
    {
        $model = $this->loadModel($id);
        $model->delete();

        if (!Yii::$app->request->getIsAjax()) {
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
