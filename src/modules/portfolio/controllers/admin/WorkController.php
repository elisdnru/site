<?php

namespace app\modules\portfolio\controllers\admin;

use app\components\crud\actions\v2\CreateAction;
use app\components\crud\actions\v2\DeleteAction;
use app\components\crud\actions\v2\ToggleAction;
use app\components\crud\actions\v2\UpdateAction;
use app\components\crud\actions\v2\ViewAction;
use CHttpException;
use app\components\AdminController;
use app\modules\portfolio\models\Work;
use Yii;
use yii\data\Pagination;

class WorkController extends AdminController
{
    private const ITEMS_PER_PAGE = 50;

    public function filters(): array
    {
        return array_merge(parent::filters(), [
            'PostOnly + sort',
        ]);
    }

    public function actions(): array
    {
        return [
            'create' => CreateAction::class,
            'update' => UpdateAction::class,
            'toggle' => [
                'class' => ToggleAction::class,
                'attributes' => ['public']
            ],
            'delete' => DeleteAction::class,
            'view' => ViewAction::class,
        ];
    }

    public function actionIndex(): string
    {
        $category = (int)Yii::app()->request->getParam('category');

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

    public function actionSort(): void
    {
        $success = true;

        $items = Yii::app()->request->getPost('item');

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

        $this->redirectOrAjax();
    }

    public function createModel(): Work
    {
        $model = new Work();
        $model->public = 1;
        $model->image_show = 1;
        $model->category_id = Yii::app()->request->getQuery('category');
        $model->date = date('Y-m-d H:i:s');
        return $model;
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
