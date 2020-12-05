<?php

use app\modules\user\models\Access;
use yii\web\View;

/**
 * @var View $this
 * @var array $series
 * @var array $items
 */

$this->context->layout = 'index';

$this->title = 'Ещё чуть-чуть...';

$this->registerMetaTag([
    'name' => 'description',
    'content' => '',
]);

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex, follow']);

$this->params['breadcrumbs'] = [
    'Подписка на обновления' => ['index'],
    'Ещё чуть-чуть...',
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
    <h1>Ещё чуть-чуть...</h1>

    <div class="text">
        <p>
            Активационное письмо отправлено. Подтвердите подписку по ссылке в этом письме.<br />
            Не забывайте проверять папку&nbsp;&laquo;Спам&raquo;. Если оно случайно попадёт туда, то откройте его и щёлкните &laquo;Не спам!&raquo;.
        </p>
        <p>С уважением, Дмитрий!</p>
    </div>
</section>
