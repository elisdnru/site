<?php

use app\modules\user\models\Access;
use app\widgets\inline\SubscribeNews;
use yii\caching\TagDependency;
use yii\helpers\Html;
use yii\web\View;

/** @var $this View */
/** @var $series array */
/** @var $items array */

$this->context->layout = 'index';

$this->title = 'Подписка на обновления';

$this->registerMetaTag([
    'name' => 'description',
    'content' => '',
]);

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex, nofollow']);

$this->params['breadcrumbs'] = [
    'Подписка на обновления',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
    }
    if (Yii::$app->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
    }
}
?>

<section>
    <h1>Подписка на обновления</h1>

    <div class="text">
        <p>Подпишитесь, если не хотите пропускать новые статьи и анонсы наших крутых мероприятий.</p>

        <?= SubscribeNews::widget() ?>
    </div>
</section>
