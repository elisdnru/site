<?php
/** @var $this Controller */

use app\modules\blog\forms\CategoryForm;
use app\modules\blog\models\Group;
use app\components\Controller;

/** @var $items Group[] */
/** @var $categoryForm CategoryForm */
/** @var $form CActiveForm */
/** @var $itemForm \app\modules\blog\forms\GroupForm */

$this->pageTitle = 'Тематические группы записей';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Записи' => ['/blog/admin/post'],
    'Тематические группы',
];

$this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post/index')];
$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/blog/admin/category/index')];
?>

<h1>Тематические группы записей</h1>

<div class="form">
    <?php echo CHtml::beginForm(); ?>

    <table class="grid">
        <tr>
            <th>Наименование</th>
            <th width="50"></th>
            <th width="16"></th>
        </tr>
        <?php foreach ($items as $item) :
            $delurl = $this->createUrl('delete', ['id' => $item->id]);
            $postsurl = $this->createUrl('blog/admin/post', ['Post[group_id]' => $item->id]);

            ?>
            <tr id="item_<?php echo $item->id; ?>">
                <td><?php echo CHtml::activeTextField($item, "[$item->id]title", ['style' => 'width:99%', 'maxlength' => 255]); ?></td>
                <td style="text-align: center"><a href="<?php echo $postsurl; ?>">Записи</a></td>
                <td style="text-align: center"><?php if ($item->posts_count === 0) : ?>
                        <a class="ajax_del" data-del="item_<?php echo $item->id; ?>" title="Удалить группу &laquo;<?php echo CHtml::encode($item->title); ?>&raquo;" href="<?php echo $delurl; ?>">
                            <img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить" />
                        </a>       <?php endif; ?></td>
            </tr>

        <?php endforeach; ?>
    </table>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->

<br />
<div class="form">

    <?php $form = $this->beginWidget(\CActiveForm::class, [
        'id' => 'category-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <?php echo $form->errorSummary($itemForm); ?>

    <table class="grid">
        <tr>
            <th>Наименование</th>
            <th width="16"></th>
        </tr>

        <tr>
            <td><?php echo $form->textField($itemForm, 'title', ['style' => 'width:99%', 'maxlength' => 255]); ?>
                <br /></td>
            <td></td>
        </tr>
    </table>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Добавить группу'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
