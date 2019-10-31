<?php

namespace app\modules\blog\controllers\admin;

use app\modules\blog\models\Category;
use app\modules\blog\models\Post;
use app\components\AdminController;
use app\modules\user\models\Access;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CategoryController extends AdminController
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Access::FULL],
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex(): string
    {
        $model = new Category('search');

        $model->unsetAttributes();
        $model->attributes = Yii::$app->request->get('Category');

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Category();

        if ($post = Yii::$app->request->post('Category')) {
            $model->attributes = $post;

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if ($post = Yii::$app->request->post('Category')) {
            $model->attributes = $post;

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id): ?Response
    {
        $model = $this->loadModel($id);

        $count = Post::model()->count([
            'condition' => 't.category_id = :id',
            'params' => [':id' => $model->id]
        ]);

        if ($count) {
            throw new BadRequestHttpException('В данной группе есть записи. Удалите их или переместите в другие категории.');
        }

        $model->delete();

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionView(): Response
    {
        return $this->redirect(['index']);
    }

    public function loadModel($id): Category
    {
        $model = Category::model()->findByPk($id);
        if ($model === null) {
            throw new NotFoundHttpException('Не найдено');
        }
        return $model;
    }
}
