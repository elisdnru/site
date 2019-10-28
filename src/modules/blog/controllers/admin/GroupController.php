<?php

namespace app\modules\blog\controllers\admin;

use app\modules\blog\forms\GroupForm;
use app\modules\blog\models\Post;
use app\modules\blog\models\Group;
use CHttpException;
use app\components\AdminController;
use Yii;

/**
 * @method renderTableForm($params)
 */
class GroupController extends AdminController
{
    public function actionIndex(): void
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

        $this->render('index', ['itemForm' => $form, 'items' => $items]);
    }

    public function actionDelete($id): void
    {
        $model = $this->loadModel($id);

        $count = Post::model()->count([
            'condition' => 't.group_id = :ID',
            'params' => [':ID' => $model->id]
        ]);

        if ($count) {
            throw new CHttpException(400, 'В данной группе есть новости. Удалите их или переместите в другие группы.');
        }

        $model->delete();

        if (!Yii::$app->request->getIsAjax()) {
            $this->redirect(['index']);
        }
    }

    public function loadModel($id): Group
    {
        $model = Group::model()->findByPk((int)$id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
