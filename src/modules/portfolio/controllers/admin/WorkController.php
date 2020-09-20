<?php

namespace app\modules\portfolio\controllers\admin;

use app\components\AdminController;
use app\modules\portfolio\models\Work;
use Yii;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class WorkController extends AdminController
{
    private const ITEMS_PER_PAGE = 50;

    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'sort' => ['post'],
                ],
            ]
        ]);
    }

    public function actionIndex(): string
    {
        $category = (int)Yii::$app->request->get('category');

        $query = Work::find();

        if ($category) {
            $query->category($category);
        }

        $pages = new Pagination([
            'totalCount' => (clone $query)->count(),
            'pageSize' => self::ITEMS_PER_PAGE,
        ]);

        $works = $query
            ->limit($pages->getLimit())
            ->offset($pages->getOffset())
            ->orderBy(['sort' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'works' => $works,
            'category' => $category,
            'pages' => $pages,
        ]);
    }

    public function actionCreate()
    {
        $model = new Work();
        $model->public = 1;
        $model->image_show = 1;
        $model->category_id = Yii::$app->request->get('category');
        $model->date = date('Y-m-d H:i:s');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @return Response|string
     */
    public function actionUpdate(int $id)
    {
        $model = $this->loadModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionToggle(int $id, $attribute): ?Response
    {
        $model = $this->loadModel($id);

        if ($attribute !== 'public') {
            throw new BadRequestHttpException('Missing attribute ' . $attribute);
        }

        $model->$attribute = $model->$attribute ? '0' : '1';
        $model->save();

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(Yii::$app->request->getReferrer() ?: ['index']);
        }
        return null;
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

    public function actionView(int $id): Response
    {
        $model = $this->loadModel($id);

        return $this->redirect($model->getUrl());
    }

    public function actionSort(): ?Response
    {
        $success = true;

        $items = Yii::$app->request->post('item');

        if ($items) {
            $sort = 0;
            $count = 0;

            foreach ($items as $id) {
                $model = $this->loadModel($id);
                if ($model->sort > $sort) {
                    $sort = $model->sort;
                }
                $count++;
            }

            if ($sort < $count) {
                $sort = $count;
            }

            foreach ($items as $id) {
                $model = $this->loadModel($id);
                $model->sort = $sort;
                $sort--;
                $success = $success && $model->save();
            }
        }

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    private function loadModel(int $id): Work
    {
        $model = Work::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
