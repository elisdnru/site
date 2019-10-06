<?php

namespace app\modules\portfolio\controllers;

use CDbCriteria;
use CHttpException;
use CPagination;
use app\modules\main\components\AdminController;
use app\modules\portfolio\models\PortfolioWork;
use Yii;

class WorkAdminController extends AdminController
{
    const ITEMS_PER_PAGE = 50;

    public function filters()
    {
        return array_merge(parent::filters(), [
            'PostOnly + sort',
        ]);
    }

    public function actions()
    {
        return [
            'create' => \app\modules\crud\components\CreateAction::class,
            'update' => \app\modules\crud\components\UpdateAction::class,
            'toggle' => [
                'class' => \app\modules\crud\components\ToggleAction::class,
                'attributes' => ['public']
            ],
            'delete' => \app\modules\crud\components\DeleteAction::class,
            'view' => \app\modules\crud\components\ViewAction::class,
        ];
    }

    public function actionIndex()
    {
        $category = (int)Yii::app()->request->getParam('category');

        $criteria = new CDbCriteria;

        if ($category) {
            $criteria->addCondition('t.category_id = :categoryID');
            $criteria->params[':categoryID'] = $category;
        }

        $count = PortfolioWork::model()->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = self::ITEMS_PER_PAGE;
        $pages->applyLimit($criteria);

        $criteria->order = 't.sort DESC';
        $criteria->with = ['category'];

        $works = PortfolioWork::model()->findAll($criteria);

        $this->render('index', [
            'works' => $works,
            'category' => $category,
            'pages' => $pages,
        ]);
    }

    public function actionSort()
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

    public function createModel()
    {
        $model = new PortfolioWork();
        $model->public = 1;
        $model->image_show = 1;
        $model->category_id = Yii::app()->request->getQuery('category');
        $model->date = date('Y-m-d H:i:s');
        return $model;
    }

    public function loadModel($id)
    {
        $model = PortfolioWork::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
