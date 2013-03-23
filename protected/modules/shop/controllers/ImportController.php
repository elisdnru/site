<?php

class ImportController extends DAdminController
{
    public function actionIndex()
    {
        $list = new XMLProductList();
        $list->host = 'http://www.inekagold.ru';

        $list->load('range/41.html');

        $items = $list->getIterator();

        echo '<br />';

        foreach ($items as $p)
        {
            $model = ShopProduct::model()->find('artikul=:artikul', array(':artikul' => $p->artikul));

            if ($model)
            {
                if ($model->delete())
                    echo 'Delete ' . $p->artikul . '<br />';
                else
                    echo 'Error ' . $p->artikul . '<br />';
            };

            $model = null;

            if (!$model)
            {
                $model = new ShopProduct();

                $category = ShopCategory::model()->findByAlias('cepi');

                $model->category_id = $category->id;
                $model->artikul = $p->artikul;
                $model->title = $p->title;
                $model->short = $p->short;
                $model->text = '<p>' . $p->text . '</p>';
                $model->price = $p->price;
                $model->count = 1000;
                $model->public = 1;
                $model->priority = 200;

                if ($model->save()){

                    echo 'Save ' . $p->artikul . '<br />';

                    $attrs = ShopProductAttribute::model()->findAll();

                    foreach ($attrs as $attr){

                        if (!empty($p->{$attr->alias})){

                            $pa = new ShopProductAttributeValue;

                            $pa->product_id = $model->id;
                            $pa->attribute_id = $attr->id;
                            $pa->value = $p->{$attr->alias};

                            if ($pa->save())
                                echo 'Save ' . $attr->alias . '<br />';

                        }

                    }

                    foreach ($p->images as $url){

                        $image = new ShopImage;
                        $image->product_id = $model->id;
                        $image->image = $url;
                        if ($image->save())
                            echo 'Save ' . $url . '<br />';

                    }

                }
            }
        }
    }
}