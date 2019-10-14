<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\Post;
use CHtml;
use app\components\Controller;
use Yii;
use Zend\Feed\Writer\Feed;

class FeedController extends Controller
{
    public function actionIndex(): void
    {
        $posts = Post::model()->published()->findAll([
            'limit' => 100,
            'order' => 'date DESC',
        ]);

        $feed = new Feed();

        $feed->setTitle('Дмитрий Елисеев');
        $feed->setDescription('ElisDN');

        $feed->setLanguage('ru');
        $feed->setDateModified(new \DateTimeImmutable());
        $feed->setLink(Yii::app()->request->hostInfo);
        $feed->setCopyright('Copyright ' . date('Y') . ' ' . ($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']));
        $feed->setGenerator('ElisDN');

        foreach ($posts as $model) {
            $item = $feed->createEntry();

            $link = Yii::app()->request->hostInfo . $model->url;
            $image = Yii::app()->request->hostInfo . $model->imageThumbUrl;

            $item->setTitle($model->title);

            $description = '';
            if ($model->image) {
                $description .= CHtml::link(CHtml::image($image, $model->title, ['style' => 'display:block; float:left; margin:0 10px 10px 0']), $link);
            }
            $description .= $model->short_purified;
            $description .= CHtml::tag('p', [], CHtml::link('Читать далее &rarr;', $link, ['rel' => 'nofollow']));

            $item->setDescription($description);

            if ($model->category) {
                $item->addCategory(['term' => $model->category->title]);
            }

            $item->setLink($link);
            $item->setDateModified(new \DateTimeImmutable($model->date));
            $item->setId('post_' . $model->id);

            $feed->addEntry($item);
        }

        header('Content-Type: text/xml;charset=UTF-8');
        echo $feed->export('rss');
        Yii::app()->end();
    }
}
