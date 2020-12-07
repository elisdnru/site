<?php

use app\modules\user\models\Access;
use yii\web\View;

/**
 * @var View $this
 * @var array $series
 * @var array $items
 */

$this->context->layout = 'index';

$this->title = 'Поддержать проект';

$this->registerMetaTag([
    'name' => 'description',
    'content' => '',
]);

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex, follow']);

$this->params['breadcrumbs'] = [
    'Поддержать проект',
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
    <h1>Поддержать проект</h1>

    <div class="text">
        <p>
            Если хотите меня за что-нибудь поблагодарить, то приобретите любой <a href="/products">мастер-класс</a>,
            вступите в клуб <a href="https://deworker.pro" target="_blank">Deworker.PRO</a>
            или <a href="/subscribe">подпишитесь</a> на рассылку.</p>
    </div>
</section>
