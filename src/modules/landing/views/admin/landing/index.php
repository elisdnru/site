<?php declare(strict_types=1);

use app\components\DataProvider;
use app\modules\landing\models\Landing;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

/**
 * @var View $this
 * @var DataProvider<Landing> $dataProvider
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

<p class="float-right"><a href="<?= Url::to(['create']); ?>">Добавить</a></p>

<h1>Лендинги</h1>

<div class="grid-view">
    <form action="?" method="get">
        <table class="items">
            <thead>
                <tr>
                    <th><?= $dataProvider->getSort()->link('title', ['class' => 'sort-link', 'label' => 'Заголовок']); ?></th>
                    <th><?= $dataProvider->getSort()->link('slug', ['class' => 'sort-link', 'label' => 'Псевдоним']); ?></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getItems() as $item) : ?>
                    <tr id="item-<?= $item->id; ?>">
                        <td>
                            <?= str_repeat('&nbsp;', $item->indent * 4); ?>
                            <a href="<?= Url::to(['update', 'id' => $item->id]); ?>"><?= Html::encode($item->title); ?></a>
                        </td>
                        <td><?= Html::encode($item->slug); ?></td>
                        <td class="button-column">
                            <a href="<?= $item->getUrl(); ?>"><span class="icon view"></span></a>
                        </td>
                        <td class="button-column">
                            <a href="<?= Url::to(['update', 'id' => $item->id]); ?>"><span class="icon edit"></span></a>
                        </td>
                        <td class="button-column">
                            <a href="<?= Url::to(['delete', 'id' => $item->id]); ?>" class="ajax-del" data-del="item-<?= $item->id; ?>"><span class="icon delete"></span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" style="visibility: hidden"></button>
    </form>
</div>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]); ?>
