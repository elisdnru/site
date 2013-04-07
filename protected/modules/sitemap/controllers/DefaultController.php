<?php

class DefaultController extends DController
{
	public function actionIndex()
	{
        if (!$xml = Yii::app()->cache->get('sitemap'))
        {
            $sitemap = new DSitemap;

            Yii::import('application.modules.page.models.*');
            DUrlRulesHelper::import('page');

            $sitemap->addModels(Page::model()->findAll(array('condition'=>'system = 0')), DSitemap::WEEKLY);

            Yii::import('application.modules.new.models.*');
            DUrlRulesHelper::import('new');

            $sitemap->addModels(News::model()->published()->findAll(), DSitemap::WEEKLY);

            if (Yii::app()->moduleManager->active('blog'))
            {
                Yii::import('application.modules.blog.models.*');
                DUrlRulesHelper::import('blog');

                $sitemap->addModels(BlogPost::model()->published()->findAll(), DSitemap::DAILY, 0.8);
            }

            if (Yii::app()->moduleManager->active('portfolio'))
            {
                Yii::import('application.modules.portfolio.models.*');
                DUrlRulesHelper::import('portfolio');

                $sitemap->addModels(PortfolioWork::model()->findAll(), DSitemap::WEEKLY);
            }

            if (Yii::app()->moduleManager->active('shop'))
            {
                Yii::import('application.modules.shop.models.*');
                DUrlRulesHelper::import('shop');

                $sitemap->addModels(ShopProduct::model()->published()->findAll(), DSitemap::WEEKLY);
            }

            $xml = $sitemap->render();

            Yii::app()->cache->set('sitemap', $xml, 3600);
        }

        header("Content-type: text/xml");
        echo $xml;
        Yii::app()->end();
	}
}