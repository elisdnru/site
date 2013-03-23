<?php

Yii::import('application.modules.new.models.*');
Yii::import('application.modules.page.models.*');

class DefaultController extends DController
{
	public function actionIndex()
	{
        $items = array();

        //

        $pages = Page::model()->findAll(array(
            'condition'=>'system = 0',
            'order'=>'title ASC',
        ));

        $items = array_merge($items, $pages);

        //

        $news = News::model()->published()->findAll(array(
            'order'=>'date DESC',
        ));

        $items = array_merge($items, $news);

        //

        if (Yii::app()->moduleManager->active('blog'))
        {
            Yii::import('application.modules.blog.models.*');
            $posts = BlogPost::model()->published()->findAll(array(
                'order'=>'date DESC',
            ));
        }
        else
            $posts = array();

        $items = array_merge($items, $posts);

        //

        if (Yii::app()->moduleManager->active('portfolio'))
        {
            Yii::import('application.modules.portfolio.models.*');
            $works = PortfolioWork::model()->findAll(array(
                'order'=>'sort ASC',
            ));
        }
        else
            $works = array();

        $items = array_merge($items, $works);

        //

        if (Yii::app()->moduleManager->active('shop'))
        {
            Yii::import('application.modules.shop.models.*');
            $products = ShopProduct::model()->findAll(array(
                'order'=>'id DESC',
            ));
        }
        else
            $products = array();

        $items = array_merge($items, $products);

        //

		$this->renderPartial('index', array(
            'items'=>$items,
        ));
	}
}