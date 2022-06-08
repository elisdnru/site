<?php declare(strict_types=1);

use app\components\DataProvider;
use app\modules\blog\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

/**
 * @var View $this
 * @var DataProvider<Category> $dataProvider
 */
$this->title = 'Категории записей';
$this->params['breadcrumbs'] = [
    'Записи' => ['/blog/admin/post/index'],
    'Категории записей',
];

$this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
$this->params['admin'][] = ['label' => 'Группы', 'url' => ['/blog/admin/group/index']];
$this->params['admin'][] = ['label' => 'Добавить категорию', 'url' => ['create']];
?>

<p class="float-right"><a href="<?= Url::to(['create']); ?>">Добавить</a></p>
<h1>Категории блога</h1>

<div class="grid-view">
    <form action="?" method="get">
        <table class="items">
            <thead>
                <tr>
                    <th><?= $dataProvider->getSort()->link('sort', ['class' => 'sort-link', 'label' => 'Позиция']); ?></th>
                    <th><?= $dataProvider->getSort()->link('title', ['class' => 'sort-link', 'label' => 'Заголовок']); ?></th>
                    <th><?= $dataProvider->getSort()->link('slug', ['class' => 'sort-link', 'label' => 'Псевдоним']); ?></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getItems() as $item) : ?>
                    <tr id="item-<?= $item->id; ?>">
                        <td style="width:50px; text-align:center">
                            <?= $item->sort; ?>
                        </td>
                        <td>
                            <?= str_repeat('&nbsp;', $item->indent * 4); ?>
                            <a href="<?= Url::to(['update', 'id' => $item->id]); ?>"><?= Html::encode($item->title); ?></a>
                        </td>
                        <td><?= Html::encode($item->slug); ?></td>
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
