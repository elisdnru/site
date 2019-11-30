<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\Category;
use app\modules\blog\models\Post;
use app\modules\blog\forms\SearchForm;
use app\modules\blog\models\Tag;
use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use app\components\Controller;
use app\components\DateLimiter;
use app\modules\page\models\Page;
use app\extensions\cachetagging\Tags;
use Yii;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        $criteria = $this->getBlogCriteria();

        return $this->render('index', [
            'dataProvider' => $this->createProvider($criteria),
            'page' => $this->loadBlogPage(),
        ]);
    }

    public function actionCategory($category): string
    {
        $category = $this->loadCategoryModel($category);

        $criteria = $this->getBlogCriteria();
        $criteria->addInCondition('t.category_id', array_merge([$category->id], $category->getChildrenArray()));

        return $this->render('category', [
            'dataProvider' => $this->createProvider($criteria),
            'page' => $this->loadBlogPage(),
            'category' => $category,
        ]);
    }

    public function actionDate($date): string
    {
        $limiter = new DateLimiter($date);

        if (!$limiter->isValid()) {
            throw new NotFoundHttpException();
        }

        $criteria = $this->getBlogCriteria();
        $criteria->addSearchCondition('t.date', $limiter->getSearchString(), false);

        return $this->render('date', [
            'dataProvider' => $this->createProvider($criteria),
            'page' => $this->loadBlogPage(),
            'date' => $limiter->getDate(),
        ]);
    }

    public function actionTag($tag)
    {
        if (!$tag = $this->loadTagModel($tag)) {
            return $this->redirect(['index']);
        }

        $criteria = $this->getBlogCriteria();
        $criteria->addInCondition('t.id', $tag->getPostIds());

        return $this->render('tag', [
            'dataProvider' => $this->createProvider($criteria),
            'page' => $this->loadBlogPage(),
            'tag' => $tag,
        ]);
    }

    public function actionSearch(): string
    {
        $criteria = $this->getBlogCriteria();

        $form = new SearchForm();

        if ($form->load(Yii::$app->request->queryParams)) {
            $criteria->addSearchCondition('t.title', $form->word);
            $criteria->addSearchCondition('t.text_purified', $form->word, true, 'OR');
            $criteria->addSearchCondition('t.short_purified', $form->word, true, 'OR');
        }

        return $this->render('search', [
            'dataProvider' => $this->createProvider($criteria),
            'page' => $this->loadBlogPage(),
            'searchForm' => $form,
        ]);
    }

    /**
     * @param string $path
     * @return Category|CActiveRecord
     * @throws NotFoundHttpException
     */
    protected function loadCategoryModel(string $path): Category
    {
        $category = Category::model()->findByPath($path);
        if (!$category) {
            throw new NotFoundHttpException();
        }
        return $category;
    }

    protected function loadTagModel(string $title): ?Tag
    {
        return Tag::model()->findByTitle($title);
    }

    protected function getBlogCriteria(): CDbCriteria
    {
        $criteria = new CDbCriteria();
        $criteria->scopes = ['published'];
        $criteria->order = 't.date DESC';
        $criteria->with = ['category'];
        return $criteria;
    }

    protected function createProvider(CDbCriteria $criteria): CActiveDataProvider
    {
        $dataProvider = new CActiveDataProvider(Post::model()->cache(0, new Tags('blog')), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => 10,
                'pageVar' => 'page',
            ]
        ]);
        return $dataProvider;
    }

    protected function loadBlogPage(): Page
    {
        if (!$page = Page::model()->cache(0, new Tags('page'))->findByPath('blog')) {
            $page = new Page;
            $page->title = 'Блог';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}
