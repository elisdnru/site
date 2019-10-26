<?php
/** @var $this Controller */

use app\components\Controller;
use app\modules\page\models\Page;
use app\modules\user\models\Access;

/** @var $page Page */
/** @var $items CModel[] */

$this->title = $page->pagetitle;

$this->registerMetaTag(['name' => 'description', 'content' => $page->description]);

$this->params['breadcrumbs'] = [
    'Карта сайта',
];

if (Yii::app()->user->checkAccess(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page']];
    }
    if ($page->id) {
        if (Yii::$app->moduleManager->allowed('page')) {
            $this->params['admin'][] = ['label' => 'Редактировать страницу', 'url' => ['/page/admin/page/edit', 'id' => $page->id]];
        }
    }
}
?>

<h1><?= CHtml::encode($page->title) ?></h1>

<div class="sitemap">

    <!--noindex-->
    <h2>Страницы</h2>
    <?= $this->renderPartial('_recursive', ['models' => $items['Page'], 'parent' => 0]) ?>
    <?= $this->renderPartial('_recursive', ['models' => $items['Landing'], 'parent' => 0]) ?>
    <!--/noindex-->

    <h2>Записи в блоге</h2>
    <ul>
        <?php foreach ($items['BlogPost'] as $model) : ?>
            <li><a href="<?= $model->url ?>"><?= CHtml::encode($model->title) ?></a></li>
        <?php endforeach; ?>
    </ul>

    <!--noindex-->
    <h2>Портфолио</h2>
    <ul>
        <?php foreach ($items['PortfolioWork'] as $model) : ?>
            <li><a href="<?= $model->url ?>"><?= CHtml::encode($model->title) ?></a></li>
        <?php endforeach; ?>
    </ul>
    <!--/noindex-->

</div>
