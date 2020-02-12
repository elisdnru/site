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
use yii\web\NotFoundHttpException;

class DefaultController extends PortfolioBaseController
{
    private const PER_PAGE = 9;

    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $this->getStartQuery(),
            'pagination' => [
                'defaultPageSize' => self::PER_PAGE,
                'forcePageParam' => false,
            ],
        ]);

        $categories = Category::find()->cache(0, new Tags('portfolio'))->roots()->orderBy('sort')->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'page' => $this->loadPortfolioPage(),
            'categories' => $categories,
        ]);
    }

    public function actionCategory(string $category): string
    {
        $model = $this->loadCategoryModel($category);

        $query = $this->getStartQuery();
        $query->andWhere(['category_id' => array_merge([$model->id], Category::find()->getChildrenArray($model->id))]);

        $subcategories = $model->children;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PER_PAGE,
            ],
        ]);

        return $this->render('category', [
            'dataProvider' => $dataProvider,
            'page' => $this->loadPortfolioPage(),
            'category' => $model,
            'subcategories' => $subcategories,
        ]);
    }

    private function loadCategoryModel(string $path): Category
    {
        /** @var Category $category */
        $category = Category::find()->findByPath($path);
        if ($category === null) {
            throw new NotFoundHttpException();
        }
        return $category;
    }

    private function getStartQuery(): WorkQuery
    {
        return Work::find()
            ->published()
            ->with('category')
            ->orderBy(['sort' => SORT_DESC])
            ->cache(0, new TagDependency(['tags' => 'portfolio']));
    }

    private function loadPortfolioPage(): Page
    {
        if (!$page = Page::find()->cache(0, new Tags('page'))->findByPath('portfolio')) {
            $page = new Page;
            $page->title = 'Портфолио';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}
