<?php
/** @var $dataProvider ActiveDataProvider */
/** @var $model BlockSearch */
$this->title = 'Блоки';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Блоки',
];

$this->params['admin'][] = ['label' => 'Добавить блок', 'url' => ['create']];

use app\modules\block\forms\BlockSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager; ?>

<p class="floatright"><a href="<?= Url::to(['create']) ?>">Добавить</a></p>
<h1>HTML-Блоки</h1>

<div class="grid-view">
    <div class="summary"><?= $dataProvider->getCount() ?> из <?= $dataProvider->getTotalCount() ?></div>
    <form action="?" method="get">
        <table class="items">
            <thead>
                <tr>
                    <th><?= $dataProvider->getSort()->link('alias', ['class' => 'sort-link', 'label' => 'Код для вставки']) ?></th>
                    <th><?= $dataProvider->getSort()->link('title', ['class' => 'sort-link', 'label' => 'Наименование']) ?></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr class="filters">
                    <td><?= Html::activeTextInput($model, 'alias') ?></td>
                    <td><?= Html::activeTextInput($model, 'title') ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getModels() as $block): ?>
                    <tr>
                        <td>[{widget:block|id=<?= Html::encode($block->alias) ?>}]</td>
                        <td>
                            <a href="<?= Url::to(['update', 'id' => $block->id]) ?>"><?= Html::encode($block->title) ?></a>
                        </td>
                        <td class="button-column"><a href="<?= Url::to(['view', 'id' => $block->id]) ?>"><span class="icon view"></span></a></td>
                        <td class="button-column"><a href="<?= Url::to(['update', 'id' => $block->id]) ?>"><span class="icon edit"></span></a></td>
                        <td class="button-column"><a href="<?= Url::to(['delete', 'id' => $block->id]) ?>" class="ajax_del"><span class="icon delete"></span></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" style="visibility: hidden"></button>
    </form>
</div>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]) ?>
