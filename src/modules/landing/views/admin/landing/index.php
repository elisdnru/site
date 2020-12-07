<?php

use app\components\category\TreeActiveDataProvider;
use app\modules\landing\models\Landing;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

/**
 * @var View $this
 * @var Landing $model
 * @var TreeActiveDataProvider $dataProvider
 */

$this->title = 'Лендинги';
$this->params['breadcrumbs'] = [
    'Лендинги',
];

if (Yii::$app->moduleAdminAccess->isGranted('landing')) {
    $this->params['admin'][] = ['label' => 'Добавить лендинг', 'url' => ['create']];
}
if (Yii::$app->moduleAdminAccess->isGranted('page')) {
    $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
}
?>

<p class="floatright"><a href="<?= Url::to(['create']) ?>">Добавить</a></p>

<h1>Лендинги</h1>

<div class="grid-view">
    <div class="summary"><?= $dataProvider->getCount() ?> из <?= $dataProvider->getTotalCount() ?></div>
    <form action="?" method="get">
        <table class="items">
            <thead>
                <tr>
                    <th><?= $dataProvider->getSort()->link('title', ['class' => 'sort-link', 'label' => 'Заголовок']) ?></th>
                    <th><?= $dataProvider->getSort()->link('alias', ['class' => 'sort-link', 'label' => 'Псевдоним']) ?></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr class="filters">
                    <td><?= Html::activeTextInput($model, 'title') ?></td>
                    <td><?= Html::activeTextInput($model, 'alias') ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getModels() as $item) : ?>
                    <tr>
                        <td>
                            <?= str_repeat('&nbsp;', $item->indent * 4) ?>
                            <a href="<?= Url::to(['update', 'id' => $item->id]) ?>"><?= Html::encode($item->title) ?></a>
                        </td>
                        <td><?= Html::encode($item->alias) ?></td>
                        <td class="button-column">
                            <a href="<?= $item->getUrl() ?>"><span class="icon view"></span></a>
                        </td>
                        <td class="button-column">
                            <a href="<?= Url::to(['update', 'id' => $item->id]) ?>"><span class="icon edit"></span></a>
                        </td>
                        <td class="button-column">
                            <a href="<?= Url::to(['delete', 'id' => $item->id]) ?>" class="ajax_del"><span class="icon delete"></span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" style="visibility: hidden"></button>
    </form>
</div>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]) ?>
