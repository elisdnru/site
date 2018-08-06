<?php

Yii::import('application.extensions.feed.*');

class FeedController extends DController
{
    public function actionIndex()
    {
        $news = News::model()->published()->findAll([
            'limit' => 100,
            'order' => 'date DESC',
        ]);

        $feed = new EFeed();

        $feed->title = Yii::app()->config->get('GENERAL.FEED_TITLE') . ' - Новости';
        $feed->description = Yii::app()->config->get('GENERAL.SITE_NAME');

        $feed->addChannelTag('language', 'ru');
        $feed->addChannelTag('pubDate', date(DATE_RSS, time()));
        $feed->addChannelTag('lastBuildDate', date(DATE_RSS, time()));
        $feed->addChannelTag('link', Yii::app()->request->hostInfo);
        $feed->addChannelTag('copyright', 'Copyright ' . date('Y') . ' ' . $_SERVER['SERVER_NAME']);

        foreach ($news as $model) {
            $item = $feed->createNewItem();

            $link = Yii::app()->request->hostInfo . $model->url;
            $image = Yii::app()->request->hostInfo . $model->imageThumbUrl;

            $item->title = $model->title;

            $description = '';
            if ($model->image) {
                $description .= CHtml::link(Chtml::image($image, $model->title, ['style' => 'display:block; float:left; margin:0 10px 10px 0']), $link);
            }
            $description .= $model->short_purified;
            $description .= CHtml::tag('p', [], CHtml::link('Читать далее &rarr;', $link, ['rel' => 'nofollow']));

            $item->description = $description;

            if ($model->page) {
                $item->addTag('category', $model->page->title);
            }

            $item->link = $link;
            $item->date = date(DATE_RSS, strtotime($model->date));
            $item->addTag('guid', 'item_' . $model->id, ['isPermaLink' => 'false']);

            $feed->addItem($item);
        }

        $feed->generateFeed();
        Yii::app()->end();
    }
}
