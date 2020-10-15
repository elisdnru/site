<?php

use app\modules\user\models\Access;
use yii\web\View;

/** @var $this View */
/** @var $series array */
/** @var $items array */

$this->context->layout = 'index';

$this->title = 'Всё получилось!';

$this->registerMetaTag([
    'name' => 'description',
    'content' => '',
]);

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex, follow']);

$this->params['breadcrumbs'] = [
    'Подписка на обновления' => ['index'],
    'Всё получилось!',
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
    <h1>Всё получилось!</h1>

    <div class="text">
        <p>Поздравляю с успешным вступлением в клуб!</p>
        <p>А пока я отвечу на некоторые возможные вопросы:</p>
        <h2>Что теперь нужно сделать?</h2>
        <p>Нужно добавить адрес рассылки в белый список контактов вашего ящика. А иначе письма могут случайно попасть в спам и до Вас не дойти.</p>
        <h2>А если надоест?</h2>
        <p>Если же Вам станет скучно получать какие-либо письма, то ответьте на любое письмо рассылки и изложите свои пожелания. Также в любое время Вы можете отписаться от рассылки по ссылке, расположенной ниже каждого письма.</p>
        <p>А пока можете <a href="/blog">продолжить чтение</a> блога.</p>
    </div>
</section>
