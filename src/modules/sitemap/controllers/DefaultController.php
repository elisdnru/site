<?php

class DefaultController extends DController
{
	public function actionIndex()
	{
		$models = array();

		Yii::import('application.modules.page.models.*');
		DUrlRulesHelper::import('page');

		$models['Page'] = Page::model()->cache(0, new Tags('page'))->findAll(array(
			'condition'=>'system = 0',
			'order'=>'title ASC',
		));

		Yii::import('application.modules.new.models.*');
		DUrlRulesHelper::import('new');

		$models['News'] = News::model()->cache(0, new Tags('news'))->published()->findAll(array(
			'order'=>'title ASC',
		));

		if (Yii::app()->moduleManager->active('blog'))
		{
			Yii::import('application.modules.blog.models.*');
			DUrlRulesHelper::import('blog');

			$models['BlogPost'] = BlogPost::model()->cache(0, new Tags('blog'))->published()->findAll(array(
				'order'=>'title ASC',
			));
		}

		if (Yii::app()->moduleManager->active('portfolio'))
		{
			Yii::import('application.modules.portfolio.models.*');
			DUrlRulesHelper::import('portfolio');

			$models['PortfolioWork'] = PortfolioWork::model()->cache(0, new Tags('portfolio'))->published()->findAll(array(
				'order'=>'title ASC',
			));
		}

		$this->render('index', array(
			'items'=>$models,
			'page'=>$this->loadSitemapPage(),
		));
	}

	public function actionXml()
	{
        if (!$xml = Yii::app()->cache->get('sitemap_xml'))
        {
            $sitemap = new DSitemap;

            Yii::import('application.modules.page.models.*');
            DUrlRulesHelper::import('page');

            $sitemap->addModels(Page::model()->findAll(array('condition'=>'system = 0 AND robots IN (\'index, follow\', \'index, nofollow\')')), DSitemap::WEEKLY);

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

            $xml = $sitemap->render();

            Yii::app()->cache->set('sitemap_xml', $xml, 3600);
        }

        header("Content-type: text/xml");
        echo $xml;
        Yii::app()->end();
	}

	/**
	 * @return Page
	 */
	private function loadSitemapPage()
	{
		if (!$page = Page::model()->cache(0, new Tags('page'))->findByPath('sitemap'))
		{
			$page = new Page;
			$page->title = 'Карта сайта';
			$page->pagetitle = $page->title;
		}
		return $page;
	}
}