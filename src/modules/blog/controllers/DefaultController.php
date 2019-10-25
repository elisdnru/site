<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\Category;
use app\modules\blog\models\Post;
use app\modules\blog\forms\SearchForm;
use app\modules\blog\models\Tag;
use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use CHttpException;
use app\components\Controller;
use app\components\DateLimiter;
use app\modules\page\models\Page;
use app\extensions\cachetagging\Tags;

class DefaultController extends Controller
{
    public function actionIndex(): void
    {
        $criteria = $this->getBlogCriteria();

        $this->render('index', [
            'dataProvider' => $this->createProvider($criteria),
            'page' => $this->loadBlogPage(),
        ]);
    }

    public function actionCategory($category): void
    {
        $category = $this->loadCategoryModel($category);

        $criteria = $this->getBlogCriteria();
        $criteria->addInCondition('t.category_id', array_merge([$category->id], $category->getChildrenArray()));

        $this->render('category', [
            'dataProvider' => $this->createProvider($criteria),
            'page' => $this->loadBlogPage(),
            'category' => $category,
        ]);
    }

    public function actionDate($date): void
    {
        $date = $this->getDateLimiter($date);

        $criteria = $this->getBlogCriteria();
        $criteria->addSearchCondition('t.date', $date->searchString, false);

        $this->render('date', [
            'dataProvider' => $this->createProvider($criteria),
            'page' => $this->loadBlogPage(),
            'date' => $date,
        ]);
    }

    public function actionTag($tag): void
    {
        if (!$tag = $this->loadTagModel($tag)) {
            $this->redirect(['index']);
            return;
        }

        $criteria = $this->getBlogCriteria();
        $criteria->addInCondition('t.id', $tag->getPostIds());

        $this->render('tag', [
            'dataProvider' => $this->createProvider($criteria),
            'page' => $this->loadBlogPage(),
            'tag' => $tag,
        ]);
    }

    public function actionSearch(): void
    {
        $criteria = $this->getBlogCriteria();

        $searchForm = new SearchForm();

        if (isset($_REQUEST['word'])) {
            $searchForm->word = $_REQUEST['word'];

            $criteria->addSearchCondition('t.title', $searchForm->word);
            $criteria->addSearchCondition('t.text_purified', $searchForm->word, true, 'OR');
            $criteria->addSearchCondition('t.short_purified', $searchForm->word, true, 'OR');
        }

        $this->render('search', [
            'dataProvider' => $this->createProvider($criteria),
            'page' => $this->loadBlogPage(),
            'searchForm' => $searchForm,
        ]);
    }

    /**
     * @param string $path
     * @return Category|CActiveRecord
     * @throws CHttpException
     */
    protected function loadCategoryModel(string $path): Category
    {
        $category = Category::model()->findByPath($path);
        if (!$category) {
            throw new CHttpException('404', 'Страница не найдена');
        }
        return $category;
    }

    protected function loadTagModel(string $title): ?Tag
    {
        return Tag::model()->findByTitle($title);
    }

    protected function getDateLimiter(string $date): DateLimiter
    {
        $dateLimiter = new DateLimiter($date);
        if (!$dateLimiter->validate()) {
            throw new CHttpException('404', 'Страница не найдена');
        }
        return $dateLimiter;
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
