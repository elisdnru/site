<?php

namespace app\modules\portfolio\controllers\admin;

use app\components\AdminController;
use app\modules\portfolio\forms\CategorySearch;
use app\modules\portfolio\models\Category;
use app\modules\portfolio\models\Work;
use app\modules\user\models\Access;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
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

    public function actionIndex(Request $request): string
    {
        $model = new CategorySearch();
        $dataProvider = $model->search($request->queryParams);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return Response|string
     */
    public function actionCreate(Request $request)
    {
        $model = new Category();

        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id, Request $request)
    {
        $model = $this->loadModel($id);

        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete(int $id, Request $request): ?Response
    {
        $model = $this->loadModel($id);

        $count = Work::find()->category($model->id)->count();
        if ($count) {
            throw new BadRequestHttpException('В данной группе есть записи. Удалите их или переместите в другие категории.');
        }

        $model->delete();

        if (!$request->getIsAjax()) {
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
        $model = Category::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
