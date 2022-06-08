<?php declare(strict_types=1);

use app\modules\blog\models\Tag;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var Tag[] $tags
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
    <form action="?" method="get">
        <table class="items">
            <thead>
                <tr>
                    <th>Заголовок</th>
                    <th>Частота</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tags as $tag) : ?>
                    <tr id="item-<?= $tag->id; ?>">
                        <td>
                            <a href="<?= Url::to(['update', 'id' => $tag->id]); ?>"><?= Html::encode($tag->title); ?></a>
                        </td>
                        <td style="width:130px; text-align:center"><?= $tag->getFrequency(); ?></td>
                        <td class="button-column">
                            <a href="<?= $tag->getUrl(); ?>"><span class="icon view"></span></a>
                        </td>
                        <td class="button-column">
                            <a href="<?= Url::to(['update', 'id' => $tag->id]); ?>"><span class="icon edit"></span></a>
                        </td>
                        <td class="button-column">
                            <a href="<?= Url::to(['delete', 'id' => $tag->id]); ?>" class="ajax-del" data-del="item-<?= $tag->id; ?>"><span class="icon delete"></span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" style="visibility: hidden"></button>
    </form>
</div>
