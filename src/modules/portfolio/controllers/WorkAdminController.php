<?php

Yii::import('application.modules.crud.components.*');

class WorkAdminController extends DAdminController
{
    const ITEMS_PER_PAGE = 50;

    public function filters()
    {
        return array_merge(parent::filters(), array(
            'PostOnly + sort',
        ));
    }

    public function actions()
    {
        return array(
            'create'=>'DCreateAction',
            'update'=>'DUpdateAction',
            'toggle'=>array(
                'class'=>'DToggleAction',
                'attributes'=>array('public')
            ),
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

	public function actionIndex()
	{
        $category = (int)Yii::app()->request->getParam('category');

        $criteria = new CDbCriteria;

        if ($category)
        {
            $criteria->addCondition('t.category_id = :categoryID');
            $criteria->params[':categoryID'] = $category;
        }

        $count = PortfolioWork::model()->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = self::ITEMS_PER_PAGE;
        $pages->applyLimit($criteria);

        $criteria->order = 't.sort DESC';
        $criteria->with = array('category');

        $works = PortfolioWork::model()->findAll($criteria);

        $this->render('index', array(
            'works'=>$works,
            'category'=>$category,
            'pages'=>$pages,
        ));
	}

    public function actionSort()
    {
        $success = true;

        $items =  Yii::app()->request->getPost('item');

        if ($items){

            $sort = 0;
            $count = 0;

            foreach ($items as $id){
                $model = $this->loadModel($id);
                if ($model->sort > $sort) $sort = $model->sort;
                $count++;
            };

            if ($sort < $count) $sort = $count;

            foreach ($items as $id){
                $model = $this->loadModel($id);
                $model->sort = $sort;
                $sort--;
                $success = $success && $model->save();
            };
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
        if (DMultilangHelper::enabled())
            $model = PortfolioWork::model()->multilang()->findByPk($id);
        else
            $model = PortfolioWork::model()->findByPk($id);

        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}