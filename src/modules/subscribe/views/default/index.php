<?php

use app\modules\user\models\Access;
use app\widgets\inline\SubscribeNews;
use yii\web\View;

/**
 * @var View $this
 * @var array $series
 * @var array $items
 */

$this->context->layout = 'index';

$this->title = 'Подписка на обновления';

$this->registerMetaTag([
    'name' => 'description',
    'content' => '',
]);

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex, follow']);

$this->params['breadcrumbs'] = [
    'Подписка на обновления',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
    }
    if (Yii::$app->moduleAdminAccess->isGranted('blog')) {
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
