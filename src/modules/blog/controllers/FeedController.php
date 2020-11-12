<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\Post;
use yii\web\Controller;
use DateTimeImmutable;
use yii\helpers\Html;
use yii\web\Request;
use yii\web\Response;
use Laminas\Feed\Writer\Feed;

class FeedController extends Controller
{
    public function actionIndex(Request $request, Response $response): Response
    {
        /** @var Post[] $posts */
        $posts = Post::find()->published()->orderBy(['date' => SORT_DESC])->limit(100)->all();

        $feed = new Feed();

        $feed->setTitle('Дмитрий Елисеев');
        $feed->setDescription('ElisDN');

        $host = (string)$request->hostInfo;

        $feed->setLanguage('ru');
        $feed->setDateModified(new DateTimeImmutable());
        $feed->setLink($host);
        $feed->setCopyright('Copyright ' . date('Y') . ' ' . ($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']));
        $feed->setGenerator('ElisDN');

        foreach ($posts as $model) {
            $item = $feed->createEntry();

            $link = $host . $model->getUrl();
            $image = $host . $model->getImageThumbUrl();

            $item->setTitle($model->title);

            $description = '';
            if ($model->image) {
                $description .= Html::a(Html::img($image, ['title' => $model->title, 'style' => 'display:block; float:left; margin:0 10px 10px 0']), $link);
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

        $response->format = Response::FORMAT_RAW;
        $response->headers->set('Content-Type', 'application/rss+xml;charset=UTF-8');
        $response->content = $feed->export('rss');
        return $response;
    }
}
