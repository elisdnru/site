<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\Post;
use CHtml;
use app\components\Controller;
use DateTimeImmutable;
use Yii;
use yii\helpers\Html;
use yii\web\Response;
use Laminas\Feed\Writer\Feed;

class FeedController extends Controller
{
    public function actionIndex(): string
    {
        /** @var Post[] $posts */
        $posts = Post::model()->published()->findAll([
            'limit' => 100,
            'order' => 'date DESC',
        ]);

        $feed = new Feed();

        $feed->setTitle('Дмитрий Елисеев');
        $feed->setDescription('ElisDN');

        $feed->setLanguage('ru');
        $feed->setDateModified(new DateTimeImmutable());
        $feed->setLink(Yii::$app->request->hostInfo);
        $feed->setCopyright('Copyright ' . date('Y') . ' ' . ($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']));
        $feed->setGenerator('ElisDN');

        foreach ($posts as $model) {
            $item = $feed->createEntry();

            $link = Yii::$app->request->hostInfo . $model->url;
            $image = Yii::$app->request->hostInfo . $model->getImageThumbUrl();

            $item->setTitle($model->title);

            $description = '';
            if ($model->image) {
                $description .= Html::a(CHtml::image($image, $model->title, ['style' => 'display:block; float:left; margin:0 10px 10px 0']), $link);
            }
            $description .= $model->short_purified;
            $description .= Html::tag('p', Html::a('Читать далее &rarr;', $link, ['rel' => 'nofollow']));

            $item->setDescription($description);

            if ($model->category) {
                $item->addCategory(['term' => $model->category->title]);
            }

            $item->setLink($link);
            $item->setDateModified(new DateTimeImmutable($model->date));
            $item->setId('post_' . $model->id);

            $feed->addEntry($item);
        }

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers['Content-Type'] = 'application/rss+xml;charset=UTF-8';
        return $feed->export('rss');
    }
}
