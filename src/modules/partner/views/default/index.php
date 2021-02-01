<?php

use app\modules\user\models\Access;
use yii\web\View;

/**
 * @var View $this
 * @var array $series
 * @var array $items
 */

$this->context->layout = 'index';

$this->title = 'Парнёрская программа';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Парнёрская программа Дмитрия Елисеева',
]);

$this->params['breadcrumbs'] = [
    'Парнёрская программа',
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
    <h1>Парнёрская программа</h1>

    <div class="text">
        <p style="text-align: center; margin: 30px 0">
            <a target="_blank" class="order-button" href="https://products.elisdn.ru/join/" rel="noopener">Подключиться к программе</a>
        </p>
    </div>
</section>
