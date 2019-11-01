<?php

namespace app\modules\blog\controllers\admin;

use app\modules\blog\forms\GroupForm;
use app\modules\blog\models\Post;
use app\modules\blog\models\Group;
use app\components\AdminController;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * @method renderTableForm($params)
 */
class GroupController extends AdminController
{
    public function actionIndex(): string
    {
        $items = Group::model()->findAll([
            'order' => 'title ASC',
        ]);

        if ($post = Yii::$app->request->post('GroupForm')) {
            $valid = true;

            foreach ($items as $item) {
                if (isset($post[$item->id])) {
                    $item->attributes = $post[$item->id];
                }
                $valid = $item->validate() && $valid;
            }

            if ($valid) {
                foreach ($items as $item) {
                    if (isset($post[$item->id])) {
                        $item->attributes = $post[$item->id];
                        $item->save();
                    }
                }

                $items = Group::model()->findAll([
                    'order' => 'title ASC',
                ]);
            }
        }

        $form = new GroupForm();

        if (isset($post)) {
            $form->attributes = $post;

            if ($form->validate()) {
                $model = new Group();
                $model->attributes = $form->attributes;

                if ($model->save()) {
                    $this->refresh();
                }
            }
        }

        return $this->render('index', ['itemForm' => $form, 'items' => $items]);
    }

    public function actionDelete($id): ?Response
    {
        $model = $this->loadModel($id);

        $count = Post::model()->count([
            'condition' => 't.group_id = :ID',
            'params' => [':ID' => $model->id]
        ]);

        if ($count) {
            throw new BadRequestHttpException('В данной группе есть новости. Удалите их или переместите в другие группы.');
        }

        $model->delete();

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function loadModel($id): Group
    {
        $model = Group::model()->findByPk((int)$id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
