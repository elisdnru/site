<?php
use app\modules\page\models\Page;
use app\modules\user\models\Access;
use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var $this View */
/** @var $items Model[] */

$this->title = 'Карта сайта';

$this->registerMetaTag(['name' => 'description', 'content' => 'Карта сайта']);

$this->params['breadcrumbs'] = [
    'Карта сайта',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page']];
    }
}
?>

<h1>Карта сайта</h1>

<div class="sitemap">

    <h2>Страницы</h2>

    <ul>
        <li>
            <a href="<?= Url::to(['/products/default/index']) ?>">Авторские продукты</a>
        </li>
    </ul>

    <?= $this->render('_recursive', ['models' => $items['Page'], 'parent' => 0]) ?>

    <h2>Продукты</h2>
    <?= $this->render('_recursive', ['models' => $items['Landing'], 'parent' => 0]) ?>

    <h2>Записи в блоге</h2>
    <ul>
        <?php foreach ($items['BlogPost'] as $model) : ?>
            <li><a href="<?= $model->getUrl() ?>"><?= Html::encode($model->title) ?></a></li>
        <?php endforeach; ?>
    </ul>

    <!--noindex-->
    <h2>Портфолио</h2>
    <ul>
        <?php foreach ($items['PortfolioWork'] as $model) : ?>
            <li><a href="<?= $model->getUrl() ?>"><?= Html::encode($model->title) ?></a></li>
        <?php endforeach; ?>
    </ul>
    <!--/noindex-->

</div>
