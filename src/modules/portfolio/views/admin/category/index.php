<?php
/** @var $model Category */
/** @var $dataProvider TreeActiveDataProviderV2 */

use app\components\category\TreeActiveDataProviderV2;
use app\modules\portfolio\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Категории портфолио';
$this->params['breadcrumbs'] = [
    'Портфолио' => ['/portfolio/admin/work/index'],
    'Категории',
];
$this->params['admin'][] = ['label' => 'Работы', 'url' => ['/portfolio/admin/work/index']];
$this->params['admin'][] = ['label' => 'Добавить категорию', 'url' => ['create']];
?>

<p class="floatright"><a href="<?= Url::to(['create']) ?>">Добавить</a></p>
<h1>Категории работ</h1>

<div class="grid-view">
    <div class="summary"><?= $dataProvider->getCount() ?> из <?= $dataProvider->getTotalCount() ?></div>
    <form action="?" method="get">
        <table class="items">
            <thead>
                <tr>
                    <th><?= $dataProvider->getSort()->link('sort', ['class' => 'sort-link', 'label' => 'Позиция']) ?></th>
                    <th><?= $dataProvider->getSort()->link('title', ['class' => 'sort-link', 'label' => 'Заголовок']) ?></th>
                    <th><?= $dataProvider->getSort()->link('alias', ['class' => 'sort-link', 'label' => 'Псевдоним']) ?></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr class="filters">
                    <td><?= Html::activeTextInput($model, 'sort') ?></td>
                    <td><?= Html::activeTextInput($model, 'title') ?></td>
                    <td><?= Html::activeTextInput($model, 'alias') ?></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getModels() as $item) : ?>
                    <tr>
                        <td style="width:50px; text-align:center">
                            <?= Html::encode($item->sort) ?>
                        </td>
                        <td>
                            <?= str_repeat('&nbsp;', $item->indent * 4) ?>
                            <a href="<?= Url::to(['update', 'id' => $item->id]) ?>"><?= Html::encode($item->title) ?></a>
                        </td>
                        <td><?= Html::encode($item->alias) ?></td>
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
