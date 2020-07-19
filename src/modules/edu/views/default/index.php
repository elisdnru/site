<?php

use app\modules\user\models\Access;
use yii\helpers\Html;
use yii\web\View;

/** @var $this View */
/** @var $series array */
/** @var $items array */

$this->context->layout = 'index';

$this->title = 'База знаний';

$this->registerMetaTag([
    'name' => 'description',
    'content' => '',
]);

$this->params['breadcrumbs'] = [
    'База знаний',
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
    <h1>База знаний</h1>

    <div class="text">
        <p>Для более удобного выкладывания видео открыл новый ресурс:</p>

        <p><a href="https://deworker.pro" target="_blank">Перейти в Базу Знаний</a></p>

        <p>
            Сейчас идёт:
            <a href="https://deworker.pro/edu/series/interactive-site" target="_blank">Разработка интерактивного
                аукциона на Slim PHP и ReactJS</a>
        </p>
    </div>
</section>
