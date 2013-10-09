<?php

Yii::import('application.extensions.feed.*');

class FeedController extends DController
{
    public function actionIndex()
    {
        $posts = BlogPost::model()->published()->findAll(array(
            'limit'=>100,
            'order'=>'date DESC',
        ));

        $feed = new EFeed();

        $feed->title= Yii::app()->config->get('GENERAL.FEED_TITLE');
        $feed->description = Yii::app()->config->get('GENERAL.SITE_NAME');

        $feed->addChannelTag('language', 'ru');
        $feed->addChannelTag('pubDate', date(DATE_RSS, time()));
        $feed->addChannelTag('lastBuildDate', date(DATE_RSS, time()));
        $feed->addChannelTag('link', Yii::app()->request->hostInfo);
        $feed->addChannelTag('copyright', 'Copyright ' . date('Y') . ' ' . $_SERVER['SERVER_NAME']);

        foreach ($posts as $model)
        {
            $item = $feed->createNewItem();

            $link = Yii::app()->request->hostInfo . $model->url;
            $image = Yii::app()->request->hostInfo . $model->imageThumbUrl;

            $item->title = $model->title;

            $description = '';
            if ($model->image) $description .= CHtml::link(Chtml::image($image, $model->title, array('style'=>'display:block; float:left; margin:0 10px 10px 0')), $link);
            $description .= $model->short_purified;
            $description .= CHtml::tag('p', array(), CHtml::link('Читать далее &rarr;', $link, array('rel'=>'nofollow')));

            $item->description = $description;

            if ($model->category)
                $item->addTag('category', $model->category->title);

            $item->link = $link;
            $item->date = date(DATE_RSS, strtotime($model->date));
            $item->addTag('guid', 'post_' . $model->id, array('isPermaLink'=>'false'));

            $feed->addItem($item);
        }

        $feed->generateFeed();
        Yii::app()->end();
    }
}