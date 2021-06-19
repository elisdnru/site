<?php declare(strict_types=1);

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
        <iframe
            src="https://yoomoney.ru/quickpay/shop-widget?writer=seller&targets=%D0%91%D0%BB%D0%B0%D0%B3%D0%BE%D0%B4%D0%B0%D1%80%D0%BD%D0%BE%D1%81%D1%82%D1%8C&targets-hint=&default-sum=&button-text=14&payment-type-choice=on&hint=&successURL=&quickpay=shop&account=41001172664775"
            width="100%" height="222" frameborder="0" allowtransparency="true" scrolling="no"
        ></iframe>

        <p>
            Помимо этого можете приобрести любой <a href="/products">мастер-класс</a>
            или подписаться на скринкасты <a href="https://deworker.pro" target="_blank">Deworker.PRO</a>
        </p>
    </div>
</section>
