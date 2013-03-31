<?php

Yii::import('application.modules.page.models.*');

class DefaultController extends ShopBaseController
{
    protected $filter;

    public function actionIndex()
    {
        $model = $this->loadSearchModel();

        $types = ShopType::model()->cache(3600*24)->findAll(array(
            'order'=>'sort ASC',
        ));

        $dataProvider = $model->cache(3600)->search(Yii::app()->config->get('SHOP.PRODUCTS_PER_PAGE'));

        $this->render('index', array(
            'dataProvider'=>$dataProvider,
            'model' => $model,
            'types' => $types,
            'page'=>$this->loadShopPage(),
        ));
    }

    public function actionSale()
    {
        $model = $this->loadSearchModel();

        $model->sale = 1;

        $dataProvider = $model->cache(3600)->search(Yii::app()->config->get('SHOP.PRODUCTS_PER_PAGE'));

        $this->render('sale', array(
            'dataProvider'=>$dataProvider,
            'model' => $model,
            'page'=>$this->loadShopPage(),
        ));
    }

    public function actionType($type)
    {
        $type = $this->loadTypeModel($type);

        $model = $this->loadSearchModel();
        $model->type_id = $type->id;

        $categories = ShopCategory::model()->type($type->id)->findAll();

        $dataProvider = $model->cache(3600)->search(Yii::app()->config->get('SHOP.PRODUCTS_PER_PAGE'));

        $this->render('type', array(
            'dataProvider'=>$dataProvider,
            'model' => $model,
            'type' => $type,
            'categories' => $categories,
            'page' => $this->loadShopPage(),
        ));
    }

    public function actionCategory($type, $category)
    {
        $type = $this->loadTypeModel($type);
        $category = $this->loadCategoryModel($category, $type->id);

        $model = $this->loadSearchModel();
        $model->type_id = $type->id;
        $model->category_id = $category->id;

        $subcategories = $category->cache(3600*24)->child_items;

        $dataProvider = $model->cache(3600)->search(Yii::app()->config->get('SHOP.PRODUCTS_PER_PAGE'));

        $this->render('category', array(
            'dataProvider'=>$dataProvider,
            'category' => $category,
            'model' => $model,
            'subcategories' => $subcategories,
            'page' => $this->loadShopPage(),
        ));
    }

    public function actionBrand($brand, $type='', $category='')
    {
        $brand = $this->loadBrandModel($brand);
        if ($type) $type = $this->loadTypeModel($type);
        if ($category) $category = $this->loadCategoryModel($category, $type->id);

        $model = $this->loadSearchModel();
        if ($type) $model->type_id = $type->id;
        if ($category) $model->category_id = $category->id;
        $model->brand_id = $brand->id;

        $dataProvider = $model->cache(3600)->search(Yii::app()->config->get('SHOP.PRODUCTS_PER_PAGE'));

        $this->render('brand', array(
            'dataProvider'=>$dataProvider,
            'brand' => $brand,
            'model' => $model,
            'type' => $type,
            'category' => $category,
            'page' => $this->loadShopPage(),
        ));
    }

    public function actionSearch()
    {
        $criteria = $this->getStartCriteria();

        $searchForm = new ShopSearchForm();

        if (isset($_REQUEST['ShopSearchForm']))
        {
            $searchForm->attributes = $_REQUEST['ShopSearchForm'];

            $criteria->addSearchCondition('t.title', $searchForm->word);
            $criteria->addSearchCondition('t.text', $searchForm->word, true, 'OR');
            $criteria->addSearchCondition('t.price', $searchForm->word, true, 'OR');
        }

        $dataProvider = new CActiveDataProvider(
            ShopProduct::model()->cache(3600*24),
            array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>Yii::app()->config->get('SHOP.PRODUCTS_PER_PAGE'),
                    'pageVar'=>'page',
                )
            )
        );

        $this->render('search', array(
            'dataProvider'=>$dataProvider,
            'page' => $this->loadShopPage(),
            'searchForm' => $searchForm,
        ));
    }

    protected function loadSearchModel()
    {
        $model = new ShopProduct('search');
        $model->unsetAttributes();

        $model->size = Yii::app()->request->getQuery('size');
        $model->color = Yii::app()->request->getQuery('color');
        $model->public = 1;
        $model->grouped = true;

        return $model;
    }

    protected function loadTypeModel($type)
    {
        $type = ShopType::model()->cache(3600 * 24)->findByAlias($type);
        if ($type === null)
            throw new CHttpException('404', 'Страница не найдена');
        return $type;
    }

    protected function loadBrandModel($type)
    {
        $type = ShopBrand::model()->cache(3600 * 24)->findByAlias($type);
        if ($type === null)
            throw new CHttpException('404', 'Страница не найдена');
        return $type;
    }

    protected function loadCategoryModel($path, $type_id=0)
    {
        $category = ShopCategory::model()->cache(3600 * 24)->type($type_id)->findByPath($path);
        if ($category === null)
            throw new CHttpException('404', 'Страница не найдена');
        return $category;
    }

    protected function loadShopPage()
    {
        if (!$page = Page::model()->findByAlias('shop'))
        {
            $page = new Page();
            $page->title = 'Каталог';
            $page->pagetitle = $page->title;
        }
        return $page;
    }

    protected function getStartCriteria()
    {
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');
        $criteria->order = 't.priority ASC, t.id DESC';
        $criteria->with = array('category', 'other_categories');

        return $criteria;
    }
}