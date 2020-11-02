<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\Category;
use app\modules\blog\forms\SearchForm;
use app\modules\blog\models\Post;
use app\modules\blog\models\Tag;
use app\components\Controller;
use Yii;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        $query = $this->getBlogQuery();

        return $this->render('index', [
            'dataProvider' => $this->createProvider($query),
        ]);
    }

    public function actionCategory(string $category): string
    {
        $model = $this->loadCategoryModel($category);

        $query = $this->getBlogQuery()
            ->andWhere(['category_id' => array_merge(
                [$model->id],
                Category::find()->getChildrenArray($model->id)
            )]);

        return $this->render('category', [
            'dataProvider' => $this->createProvider($query),
            'category' => $model,
        ]);
    }

    public function actionDate(): Response
    {
        return $this->redirect(['index'], 301);
    }

    /**
     * @param string $tag
     * @return Response|string
     */
    public function actionTag(string $tag)
    {
        if (!$model = $this->loadTagModel($tag)) {
            return $this->redirect(['index']);
        }

        $query = $this->getBlogQuery()
            ->andWhere(['id' => $model->getPostIds()]);

        return $this->render('tag', [
            'dataProvider' => $this->createProvider($query),
            'tag' => $model,
        ]);
    }

    public function actionSearch(Request $request): string
    {
        $query = $this->getBlogQuery();

        $form = new SearchForm();

        if ($form->load($request->queryParams)) {
            $query->andWhere([
                'or',
                ['like', 'title', $form->word],
                ['like', 'text_purified', $form->word],
                ['like', 'short_purified', $form->word],
            ]);
        }

        return $this->render('search', [
            'dataProvider' => $this->createProvider($query),
            'searchForm' => $form,
        ]);
    }

    private function loadCategoryModel(string $path): Category
    {
        $category = Category::find()->findByPath($path);
        if ($category === null) {
            throw new NotFoundHttpException();
        }
        /** @var Category $category */
        return $category;
    }

    private function loadTagModel(string $title): ?Tag
    {
        return Tag::findOne(['title' => $title]);
    }

    private function getBlogQuery(): ActiveQuery
    {
        return Post::find()->published()
            ->with(['category', 'tags'])
            ->orderBy(['date' => SORT_DESC]);
    }

    private function createProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query->cache(0, new TagDependency(['tags' => ['blog']])),
            'pagination' => [
                'defaultPageSize' => 10,
                'pageParam' => 'page',
                'validatePage' => false,
                'forcePageParam' => false,
            ]
        ]);
    }
}
