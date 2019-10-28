<?php

namespace app\modules\portfolio\controllers\admin;

use CHttpException;
use app\components\AdminController;
use app\modules\portfolio\models\Work;
use Yii;
use yii\data\Pagination;
use yii\web\HttpException;

class WorkController extends AdminController
{
    private const ITEMS_PER_PAGE = 50;

    public function filters(): array
    {
        return array_merge(parent::filters(), [
            'PostOnly + sort',
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

    public function actionCreate(): void
    {
        $model = new Work();
        $model->public = 1;
        $model->image_show = 1;
        $model->category_id = Yii::$app->request->get('category');
        $model->date = date('Y-m-d H:i:s');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['view', 'id' => $model->id]);
        }
        $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id): void
    {
        $model = $this->loadModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['view', 'id' => $model->id]);
        }
        $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionToggle($id, $attribute): void
    {
        $model = $this->loadModel($id);

        if ($attribute !== 'public') {
            throw new HttpException(400, 'Missing attribute ' . $attribute);
        }

        $model->$attribute = $model->$attribute ? '0' : '1';
        $model->save();

        if (!Yii::$app->request->getIsAjax()) {
            $this->redirect(Yii::$app->request->getReferrer() ?: ['index']);
        }
    }

    public function actionDelete($id): void
    {
        $model = $this->loadModel($id);
        $model->delete();

        if (!Yii::$app->request->getIsAjax()) {
            $this->redirect(['index']);
        }
    }

    public function actionView($id): void
    {
        $model = $this->loadModel($id);
        $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionSort(): void
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

        $this->redirectIfNotAjax(['index']);
    }

    public function loadModel($id): Work
    {
        $model = Work::findOne($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
