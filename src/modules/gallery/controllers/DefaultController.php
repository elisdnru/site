<?php

Yii::import('application.modules.page.models.*');

class DefaultController extends GalleryBaseController
{
    public function actionIndex()
    {
        $criteria = $this->getStartCriteria();

        $dataProvider = new CActiveDataProvider(GalleryPhoto::model()->cache(0, new Tags('gallery')), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => Yii::app()->config->get('GALLERY.PHOTOS_PER_PAGE'),
                'pageVar' => 'page',
            ],
        ]);

        $categories = GalleryCategory::model()->cache(0, new Tags('gallery'))->findAll([
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
                'page' => $this->loadGalleryPage(),
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

        $dataProvider = new CActiveDataProvider(GalleryPhoto::model()->cache(0, new Tags('gallery')), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => Yii::app()->config->get('GALLERY.PHOTOS_PER_PAGE'),
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
                'page' => $this->loadGalleryPage(),
                'category' => $category,
                'subcategories' => $subcategories,
            ]);
        }
    }

    protected function loadCategoryModel($path)
    {
        $category = GalleryCategory::model()->findByPath($path);
        if ($category === null) {
            throw new CHttpException('404', 'Страница не найдена');
        }
        return $category;
    }

    protected function getStartCriteria()
    {
        $criteria = new CDbCriteria;
        $criteria->scopes = ['published'];
        $criteria->order = 't.id DESC';
        $criteria->with = ['category'];

        return $criteria;
    }

    protected function loadGalleryPage()
    {
        if (!$page = Page::model()->cache(0, new Tags('page'))->findByPath('gallery')) {
            $page = new Page;
            $page->title = 'Галерея';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}
