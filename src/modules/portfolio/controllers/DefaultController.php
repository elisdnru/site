<?php

namespace app\modules\portfolio\controllers;

use app\modules\portfolio\models\query\WorkQuery;
use app\modules\page\models\Page;
use app\modules\portfolio\components\PortfolioBaseController;
use app\modules\portfolio\models\Category;
use app\modules\portfolio\models\Work;
use app\extensions\cachetagging\Tags;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;

class DefaultController extends PortfolioBaseController
{
    private const PER_PAGE = 9;

    public function actionIndex(): string
    {
        $criteria = $this->getStartQuery();

        $dataProvider = new ActiveDataProvider([
            'query' => $criteria,
            'pagination' => [
                'defaultPageSize' => self::PER_PAGE,
                'forcePageParam' => false,
            ],
        ]);

        $categories = Category::model()->cache(0, new Tags('portfolio'))->findAll([
            'condition' => 'parent_id = 0',
            'order' => 'sort ASC',
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'page' => $this->loadPortfolioPage(),
            'categories' => $categories,
        ]);
    }

    public function actionCategory($category): string
    {
        $category = $this->loadCategoryModel($category);

        $query = $this->getStartQuery();
        $query->andWhere(['category_id' => array_merge([$category->id], $category->getChildrenArray())]);

        /** @var Category $cached */
        $cached = $category->cache(3600 * 24);
        $subcategories = $cached->child_items;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PER_PAGE,
            ],
        ]);

        return $this->render('category', [
            'dataProvider' => $dataProvider,
            'page' => $this->loadPortfolioPage(),
            'category' => $category,
            'subcategories' => $subcategories,
        ]);
    }

    protected function loadCategoryModel($path): Category
    {
        /** @var Category $category */
        $category = Category::model()->findByPath($path);
        if ($category === null) {
            throw new HttpException(404, 'Страница не найдена');
        }
        return $category;
    }

    protected function getStartQuery(): WorkQuery
    {
        return Work::find()
            ->published()
            ->orderBy(['sort' => SORT_DESC])
            ->cache(0, new TagDependency(['tags' => 'portfolio']));
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
