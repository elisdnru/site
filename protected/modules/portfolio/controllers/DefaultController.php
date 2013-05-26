<?php

Yii::import('application.modules.page.models.*');

class DefaultController extends PortfolioBaseController
{
	public function actionIndex()
	{
        $criteria = $this->getStartCriteria();

        $dataProvider = new CActiveDataProvider(PortfolioWork::model()->cache(3600*24), array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->config->get('PORTFOLIO.ITEMS_PER_PAGE'),
                'pageVar'=>'page',
            ),
        ));

        $categories = PortfolioCategory::model()->cache(3600*24)->findAll(array(
            'condition'=>'parent_id = 0',
            'order'=>'sort ASC',
        ));

        if (Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_loop',array(
                'dataProvider'=>$dataProvider,
            ));
        }
        else
        {
            $this->render('index',array(
                'dataProvider'=>$dataProvider,
                'page'=>$this->loadPortfolioPage(),
                'categories'=>$categories,
            ));
        }
	}

	public function actionCategory($category)
	{
        $category = $this->loadCategoryModel($category);

        $criteria = $this->getStartCriteria();
        $criteria->addInCondition('t.category_id', CArray::merge(array($category->id), $category->getChildsArray()));

        $subcategories = $category->cache(3600*24)->child_items;

        $dataProvider = new CActiveDataProvider(PortfolioWork::model()->cache(3600*24), array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->config->get('PORTFOLIO.ITEMS_PER_PAGE'),
                'pageVar'=>'page',
            ),
        ));

        if (Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_loop',array(
                'dataProvider'=>$dataProvider,
            ));
        }
        else
        {
            $this->render('category',array(
                'dataProvider'=>$dataProvider,
                'page'=>$this->loadPortfolioPage(),
                'category'=>$category,
                'subcategories'=>$subcategories,
            ));
        }
	}

    protected function loadCategoryModel($path)
    {
        $category = PortfolioCategory::model()->findByPath($path);
        if ($category === null)
            throw new CHttpException('404', 'Страница не найдена');
        return $category;
    }

    protected function getStartCriteria()
    {
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');
        $criteria->order = 't.sort DESC';
        $criteria->with = array('category');

        return $criteria;
    }

    protected function loadPortfolioPage()
    {
        if (!$page = Page::model()->cache(3600*24)->findByAlias('portfolio'))
        {
            $page = new Page();
            $page->title = 'Портфолио';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}