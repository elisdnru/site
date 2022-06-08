<?php declare(strict_types=1);

use app\modules\blog\models\Group;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var Group[] $groups
 */
$this->title = 'Метки записей';
$this->params['breadcrumbs'] = [
    'Записи' => ['/blog/admin/post/index'],
    'Группы записей',
];

$this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
$this->params['admin'][] = ['label' => 'Категории', 'url' => ['/blog/admin/category/index']];
$this->params['admin'][] = ['label' => 'Метки', 'url' => ['/blog/admin/tag/index']];
$this->params['admin'][] = ['label' => 'Добавить группу', 'url' => ['create']];
?>

<p class="float-right"><a href="<?= Url::to(['create']); ?>">Добавить</a></p>
<h1>Тематические группы записей</h1>

<div class="grid-view">
    <form action="?" method="get">
        <table class="items">
            <thead>
                <tr>
                    <th>Заголовок</th>
                    <th>Статей</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($groups as $group) : ?>
                    <tr id="item-<?= $group->id; ?>">
                        <td>
                            <a href="<?= Url::to(['update', 'id' => $group->id]); ?>"><?= Html::encode($group->title); ?></a>
                        </td>
                        <td style="width:130px; text-align:center"><?= $group->getPostsCount(); ?></td>
                        <td class="button-column">
                            <a href="<?= Url::to(['update', 'id' => $group->id]); ?>"><span class="icon edit"></span></a>
                        </td>
                        <td class="button-column">
                            <a href="<?= Url::to(['delete', 'id' => $group->id]); ?>" class="ajax-del" data-del="item-<?= $group->id; ?>"><span class="icon delete"></span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" style="visibility: hidden"></button>
    </form>
</div>
