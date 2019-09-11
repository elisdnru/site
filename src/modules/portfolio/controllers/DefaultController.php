<?php

namespace app\modules\portfolio\controllers;

use CActiveDataProvider;
use CArray;
use CDbCriteria;
use CHttpException;
use Page;
use PortfolioBaseController;
use PortfolioCategory;
use PortfolioWork;
use Tags;
use Yii;

Yii::import('application.modules.page.models.*');

class DefaultController extends PortfolioBaseController
{
    private const PER_PAGE = 9;

    public function actionIndex()
    {
        $criteria = $this->getStartCriteria();

        $dataProvider = new CActiveDataProvider(PortfolioWork::model()->cache(0, new Tags('portfolio')), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PER_PAGE,
                'pageVar' => 'page',
            ],
        ]);

        $categories = PortfolioCategory::model()->cache(0, new Tags('portfolio'))->findAll([
            'condition' => 'parent_id = 0',
            'order' => 'sort ASC',
        ]);

        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('_loop', [
                'dataProvider' => $dataProvider,
            ]);
        } else {
            $this->render('index', [
                'dataProvider' => $dataProvider,
                'page' => $this->loadPortfolioPage(),
                'categories' => $categories,
            ]);
        }
    }

    public function actionCategory($category)
    {
        $category = $this->loadCategoryModel($category);

        $criteria = $this->getStartCriteria();
        $criteria->addInCondition('t.category_id', CArray::merge([$category->id], $category->getChildsArray()));

        $subcategories = $category->cache(3600 * 24)->child_items;

        $dataProvider = new CActiveDataProvider(PortfolioWork::model()->cache(0, new Tags('portfolio')), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PER_PAGE,
                'pageVar' => 'page',
            ],
        ]);

        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('_loop', [
                'dataProvider' => $dataProvider,
            ]);
        } else {
            $this->render('category', [
                'dataProvider' => $dataProvider,
                'page' => $this->loadPortfolioPage(),
                'category' => $category,
                'subcategories' => $subcategories,
            ]);
        }
    }

    protected function loadCategoryModel($path)
    {
        $category = PortfolioCategory::model()->findByPath($path);
        if ($category === null) {
            throw new CHttpException('404', 'Страница не найдена');
        }
        return $category;
    }

    protected function getStartCriteria()
    {
        $criteria = new CDbCriteria;
        $criteria->scopes = ['published'];
        $criteria->order = 't.sort DESC';
        $criteria->with = ['category'];

        return $criteria;
    }

    protected function loadPortfolioPage()
    {
        if (!$page = Page::model()->cache(0, new Tags('page'))->findByPath('portfolio')) {
            $page = new Page;
            $page->title = 'Портфолио';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}
