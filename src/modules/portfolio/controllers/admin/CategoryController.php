<?php

namespace app\modules\portfolio\controllers\admin;

use app\components\AdminController;
use app\modules\portfolio\models\Category;
use app\modules\portfolio\models\Work;
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

    public function actionUpdate(int $id)
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

    public function actionDelete(int $id): ?Response
    {
        $model = $this->loadModel($id);

        $count = Work::find()->category($model->id)->count();
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

    private function loadModel(int $id): Category
    {
        $model = Category::model()->findByPk($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
