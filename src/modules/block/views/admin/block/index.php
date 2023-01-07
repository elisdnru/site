<?php declare(strict_types=1);

use app\modules\block\models\Block;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var Block[] $blocks
 */
$this->title = 'Блоки';
$this->params['breadcrumbs'] = [
    'Блоки',
];

$this->params['admin'][] = ['label' => 'Добавить блок', 'url' => ['create']];
?>

<p class="float-right"><a href="<?= Url::to(['create']); ?>">Добавить</a></p>
<h1>HTML-Блоки</h1>

<div class="grid-view">
    <form action="?" method="get">
        <table class="items">
            <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Код для вставки</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($blocks as $block): ?>
                    <tr id="item-<?= $block->id; ?>">
                        <td>
                            <a href="<?= Url::to(['update', 'id' => $block->id]); ?>"><?= Html::encode($block->title); ?></a>
                        </td>
                        <td>[{widget:block|id=<?= Html::encode($block->slug); ?>}]</td>
                        <td class="button-column"><a href="<?= Url::to(['view', 'id' => $block->id]); ?>"><span class="icon view"></span></a></td>
                        <td class="button-column"><a href="<?= Url::to(['update', 'id' => $block->id]); ?>"><span class="icon edit"></span></a></td>
                        <td class="button-column"><a href="<?= Url::to(['delete', 'id' => $block->id]); ?>" class="ajax-del" data-del="item-<?= $block->id; ?>"><span class="icon delete"></span></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" style="visibility: hidden"></button>
    </form>
</div>
