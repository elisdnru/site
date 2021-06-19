<?php declare(strict_types=1);

use app\components\DataProvider;
use app\modules\blog\models\Tag;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

/**
 * @var View $this
 * @var DataProvider<Tag> $dataProvider
 */
$this->title = 'Метки записей';
$this->params['breadcrumbs'] = [
    'Записи' => ['/blog/admin/post/index'],
    'Метки записей',
];

$this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
$this->params['admin'][] = ['label' => 'Категории', 'url' => ['/blog/admin/category/index']];
$this->params['admin'][] = ['label' => 'Группы', 'url' => ['/blog/admin/group/index']];
$this->params['admin'][] = ['label' => 'Добавить метку', 'url' => ['create']];
?>

<p class="float-right"><a href="<?= Url::to(['create']); ?>">Добавить</a></p>
<h1>Метки записей блога</h1>

<div class="grid-view">
    <div class="summary"><?= $dataProvider->getCount(); ?> из <?= $dataProvider->getTotalCount(); ?></div>
    <form action="?" method="get">
        <table class="items">
            <thead>
                <tr>
                    <th><?= $dataProvider->getSort()->link('title', ['class' => 'sort-link', 'label' => 'Заголовок']); ?></th>
                    <th>Частота</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getItems() as $item) : ?>
                    <tr>
                        <td>
                            <a href="<?= Url::to(['update', 'id' => $item->id]); ?>"><?= Html::encode($item->title); ?></a>
                        </td>
                        <td style="width:130px; text-align:center"><?= $item->getFrequency(); ?></td>
                        <td class="button-column">
                            <a href="<?= $item->getUrl(); ?>"><span class="icon view"></span></a>
                        </td>
                        <td class="button-column">
                            <a href="<?= Url::to(['update', 'id' => $item->id]); ?>"><span class="icon edit"></span></a>
                        </td>
                        <td class="button-column">
                            <a href="<?= Url::to(['delete', 'id' => $item->id]); ?>" class="ajax-del"><span class="icon delete"></span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" style="visibility: hidden"></button>
    </form>
</div>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]); ?>
