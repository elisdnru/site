<?php

declare(strict_types=1);

namespace app\modules\portfolio\controllers;

use app\components\DataProvider;
use app\modules\portfolio\models\Category;
use app\modules\portfolio\models\Work;
use app\modules\portfolio\models\WorkQuery;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    private const PER_PAGE = 9;

    public function actionIndex(): string
    {
        $dataProvider = new DataProvider(new ActiveDataProvider([
            'query' => $this->getStartQuery(),
            'pagination' => [
                'defaultPageSize' => self::PER_PAGE,
                'forcePageParam' => false,
            ],
        ]));

        /** @var Category[] $categories */
        $categories = Category::find()->roots()->cache(0, new TagDependency(['tags' => ['portfolio']]))
            ->orderBy('sort')->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'categories' => $categories,
        ]);
    }

    public function actionCategory(string $category): string
    {
        $model = $this->loadCategoryModel($category);

        $query = $this->getStartQuery();
        $query->andWhere(['category_id' => array_merge([$model->id], Category::find()->getChildrenArray($model->id))]);

        $subcategories = $model->children;

        $dataProvider = new DataProvider(new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => self::PER_PAGE,
                'forcePageParam' => false,
            ],
        ]));

        return $this->render('category', [
            'dataProvider' => $dataProvider,
            'category' => $model,
            'subcategories' => $subcategories,
        ]);
    }

    private function loadCategoryModel(string $path): Category
    {
        /** @var Category|null $category */
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
}
