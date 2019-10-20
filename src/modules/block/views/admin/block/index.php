<?php
/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $model \app\modules\block\models\search\BlockSearch */
$this->pageTitle = 'Блоки';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Блоки',
];

$this->admin[] = ['label' => 'Добавить блок', 'url' => $this->createUrl('create')];

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager; ?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>HTML-Блоки</h1>

<div id="posts-grid" class="grid-view">
    <div class="summary"><?= $dataProvider->getCount() ?> из <?= $dataProvider->getTotalCount() ?></div>
    <form action="?" method="get">
        <table class="items">
            <thead>
                <tr>
                    <th><?= $dataProvider->getSort()->link('alias', ['class' => 'sort-link', 'label' => 'Код для вставки']) ?></th>
                    <th><?= $dataProvider->getSort()->link('title', ['class' => 'sort-link', 'label' => 'Наименование']) ?></th>
                    <th class="button-column"></th>
                    <th class="button-column"></th>
                    <th class="button-column"></th>
                </tr>
                <tr class="filters">
                    <td><?= Html::activeTextInput($model, 'alias') ?></td>
                    <td><?= Html::activeTextInput($model, 'title') ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getModels() as $block): ?>
                    <tr>
                        <td>[{widget:block|id=<?= Html::encode($block->alias) ?>}]</td>
                        <td>
                            <a href="<?= Url::to(['update', 'id' => $block->id]) ?>"><?= Html::encode($block->title) ?></a>
                        </td>
                        <td class="button-column">
                            <a class="view" title="Просмотреть" href="<?= Url::to(['view', 'id' => $block->id]) ?>"><img src="/images/admin/view.png" alt="Просмотреть"></a>
                        </td>
                        <td class="button-column">
                            <a class="update" title="Редактировать" href="<?= Url::to(['update', 'id' => $block->id]) ?>"><img src="/images/admin/edit.png" alt="Редактировать"></a>
                        </td>
                        <td class="button-column">
                            <a class="delete ajax_del" title="Удалить" href="<?= Url::to(['delete', 'id' => $block->id]) ?>"><img src="/images/admin/del.png" alt="Удалить"></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" style="visibility: hidden"></button>
    </form>
</div>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]) ?>
