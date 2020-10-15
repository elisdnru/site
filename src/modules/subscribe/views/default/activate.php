<?php

use app\modules\user\models\Access;
use yii\web\View;

/** @var $this View */
/** @var $series array */
/** @var $items array */

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
    if (Yii::$app->moduleManager->allowed('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
    }
    if (Yii::$app->moduleManager->allowed('blog')) {
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
