<?php
/** @var $this \yii\web\View */

use app\components\category\TreeActiveDataProvider;
use app\modules\menu\models\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var $items Menu[] */
/** @var $model Menu */
/** @var $dataProvider TreeActiveDataProvider */

$this->title = 'Меню';
$this->params['breadcrumbs'] = [
    'Меню',
];

if (Yii::$app->moduleManager->allowed('page')) {
    $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
}
$this->params['admin'][] = ['label' => 'Добавить пункт', 'url' => ['create']];
?>

<p class="floatright"><a href="<?= Url::to(['create']) ?>">Добавить</a></p>

<h1>Пункты меню</h1>

<div class="grid-view">
    <div class="summary"><?= $dataProvider->getCount() ?> из <?= $dataProvider->getTotalCount() ?></div>
    <form action="?" method="get">
        <table class="items">
            <thead>
                <tr>
                    <th><?= $dataProvider->getSort()->link('sort', ['class' => 'sort-link', 'label' => 'Позиция']) ?></th>
                    <th><?= $dataProvider->getSort()->link('title', ['class' => 'sort-link', 'label' => 'Заголовок']) ?></th>
                    <th><?= $dataProvider->getSort()->link('link', ['class' => 'sort-link', 'label' => 'Ссылка']) ?></th>
                    <th><?= $dataProvider->getSort()->link('alias', ['class' => 'sort-link', 'label' => 'Псевдоним']) ?></th>
                    <th><?= $dataProvider->getSort()->link('visible', ['class' => 'sort-link', 'label' => 'В']) ?></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr class="filters">
                    <td><?= Html::activeTextInput($model, 'sort') ?></td>
                    <td><?= Html::activeTextInput($model, 'title') ?></td>
                    <td><?= Html::activeTextInput($model, 'link') ?></td>
                    <td><?= Html::activeTextInput($model, 'alias') ?></td>
                    <td><?= Html::activeDropDownList($model, 'visible', [1 => 'Видимые', 0 => 'Скрытые'], ['prompt' => '']) ?></td>
                    <td></td>
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
                        <td><?= Html::encode($item->link) ?></td>
                        <td><?= Html::encode($item->alias) ?></td>
                        <td style="width:30px;text-align:center">
                            <a class="ajax_post" href="<?= Url::to(['toggle', 'id' => $item->id, 'attribute' => 'visible']) ?>">
                                <?php if ($item->visible) : ?>
                                    <img title="Прочитано" style="width:16px; height:16px;" class="icon-on" src="/images/admin/yes.png" alt="Видимо">
                                <?php else : ?>
                                    <img title="Новое" style="width:16px; height:16px;" class="icon-off" src="/images/admin/no.png" alt="Скрыто">
                                <?php endif; ?>
                            </a>
                        </td>
                        <td class="button-column">
                            <a href="<?= Url::to(['view', 'id' => $item->id]) ?>"><span class="icon view"></span></a>
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
