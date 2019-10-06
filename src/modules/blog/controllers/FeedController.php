<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\BlogPost;
use CHtml;
use app\modules\main\components\Controller;
use app\extensions\feed\EFeed;
use Yii;

class FeedController extends Controller
{
    public function actionIndex()
    {
        $posts = BlogPost::model()->published()->findAll([
            'limit' => 100,
            'order' => 'date DESC',
        ]);

        $feed = new EFeed();

        $feed->title = Yii::app()->params['GENERAL.FEED_TITLE'];
        $feed->description = Yii::app()->params['GENERAL.SITE_NAME'];

        $feed->addChannelTag('language', 'ru');
        $feed->addChannelTag('pubDate', date(DATE_RSS));
        $feed->addChannelTag('lastBuildDate', date(DATE_RSS));
        $feed->addChannelTag('link', Yii::app()->request->hostInfo);
        $feed->addChannelTag('copyright', 'Copyright ' . date('Y') . ' ' . $_SERVER['SERVER_NAME']);

        foreach ($posts as $model) {
            $item = $feed->createNewItem();

            $link = Yii::app()->request->hostInfo . $model->url;
            $image = Yii::app()->request->hostInfo . $model->imageThumbUrl;

            $item->title = $model->title;

            $description = '';
            if ($model->image) {
                $description .= CHtml::link(CHtml::image($image, $model->title, ['style' => 'display:block; float:left; margin:0 10px 10px 0']), $link);
            }
            $description .= $model->short_purified;
            $description .= CHtml::tag('p', [], CHtml::link('Читать далее &rarr;', $link, ['rel' => 'nofollow']));

            $item->description = $description;

            if ($model->category) {
                $item->addTag('category', $model->category->title);
            }

            $item->link = $link;
            $item->date = date(DATE_RSS, strtotime($model->date));
            $item->addTag('guid', 'post_' . $model->id, ['isPermaLink' => 'false']);

            $feed->addItem($item);
        }

        $feed->generateFeed();
        Yii::app()->end();
    }
}
