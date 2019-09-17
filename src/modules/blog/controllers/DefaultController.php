<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\BlogCategory;
use app\modules\blog\models\BlogPost;
use app\modules\blog\models\BlogSearchForm;
use app\modules\blog\models\BlogTag;
use CActiveDataProvider;
use app\components\CArray;
use CDbCriteria;
use CHttpException;
use app\modules\main\components\Controller;
use app\modules\main\components\DateLimiter;
use app\modules\page\models\Page;
use app\extensions\cachetagging\Tags;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $criteria = $this->getBlogCriteria();

        $this->render('index', [
            'dataProvider' => $this->createProvider($criteria),
            'page' => $this->loadBlogPage(),
        ]);
    }

    public function actionCategory($category)
    {
        $category = $this->loadCategoryModel($category);

        $criteria = $this->getBlogCriteria();
        $criteria->addInCondition('t.category_id', CArray::merge([$category->id], $category->getChildsArray()));

        $this->render('category', [
            'dataProvider' => $this->createProvider($criteria),
            'page' => $this->loadBlogPage(),
            'category' => $category,
        ]);
    }

    public function actionDate($date)
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

    public function actionTag($tag)
    {
        $tag = $this->loadTagModel($tag);

        $criteria = $this->getBlogCriteria();
        $criteria->addInCondition('t.id', $tag->getPostIds());

        $this->render('tag', [
            'dataProvider' => $this->createProvider($criteria),
            'page' => $this->loadBlogPage(),
            'tag' => $tag,
        ]);
    }

    public function actionSearch()
    {
        $criteria = $this->getBlogCriteria();

        $searchForm = new BlogSearchForm();

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
     * @return BlogCategory
     * @throws CHttpException
     */
    protected function loadCategoryModel($path)
    {
        $category = BlogCategory::model()->findByPath($path);
        if (!$category) {
            throw new CHttpException('404', 'Страница не найдена');
        }
        return $category;
    }

    /**
     * @param string $tag
     * @return BlogTag
     * @throws CHttpException
     */
    protected function loadTagModel($tag)
    {
        $tag = BlogTag::model()->findByTitle($tag);
        if (!$tag) {
            throw new CHttpException('404', 'Страница не найдена');
        }
        return $tag;
    }

    /**
     * @param string $date
     * @return DateLimiter
     * @throws CHttpException
     */
    protected function getDateLimiter($date)
    {
        $dateLimiter = new DateLimiter($date);
        if (!$dateLimiter->validate()) {
            throw new CHttpException('404', 'Страница не найдена');
        }
        return $dateLimiter;
    }

    /**
     * @return CDbCriteria
     */
    protected function getBlogCriteria()
    {
        $criteria = new CDbCriteria();
        $criteria->scopes = ['published'];
        $criteria->order = 't.date DESC';
        $criteria->with = ['category'];
        return $criteria;
    }

    /**
     * @param CDbCriteria $criteria
     * @return CActiveDataProvider
     */
    protected function createProvider($criteria)
    {
        $dataProvider = new CActiveDataProvider(BlogPost::model()->cache(0, new Tags('blog')), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => 10,
                'pageVar' => 'page',
            ]
        ]);
        return $dataProvider;
    }

    /**
     * @return Page
     */
    protected function loadBlogPage()
    {
        if (!$page = Page::model()->cache(0, new Tags('page'))->findByPath('blog')) {
            $page = new Page;
            $page->title = 'Блог';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}
