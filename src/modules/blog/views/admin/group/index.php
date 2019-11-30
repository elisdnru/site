<?php
/** @var $this View */

use app\modules\blog\forms\CategoryForm;
use app\modules\blog\forms\GroupForm;
use app\modules\blog\models\Group;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var $items Group[] */
/** @var $categoryForm CategoryForm */
/** @var $form CActiveForm */
/** @var $itemForm GroupForm */

$this->title = 'Тематические группы записей';
$this->params['breadcrumbs'] = [
    'Записи' => ['/blog/admin/post'],
    'Тематические группы',
];

$this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
$this->params['admin'][] = ['label' => 'Категории', 'url' => ['/blog/admin/category/index']];
?>

<h1>Тематические группы записей</h1>

<div class="form">
    <?= Html::beginForm() ?>

    <table class="grid">
        <tr>
            <th>Наименование</th>
            <th width="50"></th>
            <th width="16"></th>
        </tr>
        <?php foreach ($items as $item) :
            $delurl = Url::to(['delete', 'id' => $item->id]);
            $postsurl = Url::to(['/blog/admin/post', 'Post[group_id]' => $item->id]);

            ?>
            <tr id="item_<?= $item->id ?>">
                <td><?= CHtml::activeTextField($item, "[$item->id]title", ['style' => 'width:99%', 'maxlength' => 255]) ?></td>
                <td style="text-align: center"><a href="<?= $postsurl ?>">Записи</a></td>
                <td style="text-align: center">
                    <?php if ($item->posts_count === 0) : ?>
                        <a class="ajax_del" data-del="item_<?= $item->id ?>" title="Удалить группу &laquo;<?= Html::encode($item->title) ?>&raquo;" href="<?= $delurl ?>">
                            <img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить">
                        </a>
                    <?php endif; ?>
                </td>
            </tr>

        <?php endforeach; ?>
    </table>
    <div class="row buttons">
        <?= Html::submitButton('Сохранить') ?>
    </div>
    <?= Html::endForm() ?>
</div><!-- form -->

<br />
<div class="form">

    <?= Html::beginForm() ?>

    <table class="grid">
        <tr>
            <th>Наименование</th>
            <th width="16"></th>
        </tr>

        <tr>
            <td>
                <?= Html::activeTextInput($itemForm, 'title', ['style' => 'width:99%', 'maxlength' => 255]) ?><br />
                <?= Html::error($itemForm, 'title') ?>
            </td>
            <td></td>
        </tr>
    </table>
    <div class="row buttons">
        <?= Html::submitButton('Добавить группу') ?>
    </div>

    <?= Html::endForm() ?>

</div><!-- form -->
