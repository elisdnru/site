<?php

namespace app\modules\portfolio\controllers;

use CActiveDataProvider;
use CDbCriteria;
use CHttpException;
use app\modules\page\models\Page;
use app\modules\portfolio\components\PortfolioBaseController;
use app\modules\portfolio\models\Category;
use app\modules\portfolio\models\Work;
use app\extensions\cachetagging\Tags;
use Yii;

class DefaultController extends PortfolioBaseController
{
    private const PER_PAGE = 9;

    public function actionIndex(): void
    {
        $criteria = $this->getStartCriteria();

        $dataProvider = new CActiveDataProvider(Work::model()->cache(0, new Tags('portfolio')), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PER_PAGE,
                'pageVar' => 'page',
            ],
        ]);

        $categories = Category::model()->cache(0, new Tags('portfolio'))->findAll([
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

    public function actionCategory($category): void
    {
        $category = $this->loadCategoryModel($category);

        $criteria = $this->getStartCriteria();
        $criteria->addInCondition('t.category_id', array_merge([$category->id], $category->getChildsArray()));

        /** @var Category $cached */
        $cached = $category->cache(3600 * 24);
        $subcategories = $cached->child_items;

        $dataProvider = new CActiveDataProvider(Work::model()->cache(0, new Tags('portfolio')), [
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

    protected function loadCategoryModel($path): Category
    {
        /** @var Category $category */
        $category = Category::model()->findByPath($path);
        if ($category === null) {
            throw new CHttpException('404', 'Страница не найдена');
        }
        return $category;
    }

    protected function getStartCriteria(): CDbCriteria
    {
        $criteria = new CDbCriteria;
        $criteria->scopes = ['published'];
        $criteria->order = 't.sort DESC';
        $criteria->with = ['category'];

        return $criteria;
    }

    protected function loadPortfolioPage(): Page
    {
        if (!$page = Page::model()->cache(0, new Tags('page'))->findByPath('portfolio')) {
            $page = new Page;
            $page->title = 'Портфолио';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}
