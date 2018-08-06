<?php
$this->pageTitle = 'Тематические группы новостей';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Новости' => ['/new/newAdmin/index'],
    'Тематические группы новостей',
];

$this->admin[] = ['label' => 'Новости', 'url' => $this->createUrl('index')];
if ($this->moduleAllowed('page')) {
    $this->admin[] = ['label' => 'Новостные страницы', 'url' => $this->createUrl('/new/pageAdmin/index')];
}

$this->info = 'Нельзя удалить группу, пока в ней есть новости';
?>

<h1>Тематические группы новостей</h1>

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
            $newsurl = $this->createUrl('/new/newAdmin', ['News[group_id]' => $item->id]);

            ?>
            <tr id="item_<?php echo $item->id; ?>">
                <td><?php echo CHtml::activeTextField($item, "[$item->id]title", ['style' => 'width:99%', 'maxlength' => 255]); ?></td>
                <td class="center"><a href="<?php echo $newsurl; ?>">Новости</a></td>
                <td class="center"><?php if ($item->news_count == 0) : ?>
                        <a class="ajax_del" data-del="item_<?php echo $item->id; ?>" title="Удалить группу &laquo;<?php echo CHtml::encode($item->title); ?>&raquo;" href="<?php echo $delurl; ?>">
                            <img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить"/>
                        </a>       <?php endif; ?></td>
            </tr>

        <?php endforeach; ?>
    </table>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->

<br/>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'category-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <?php echo $form->errorSummary($categoryForm); ?>

    <table class="grid">
        <tr>
            <th>Наименование</th>
            <th width="16"></th>
        </tr>

        <tr>
            <td><?php echo $form->textField($categoryForm, 'title', ['style' => 'width:99%', 'maxlength' => 255]); ?>
                <br/></td>
            <td></td>
        </tr>
    </table>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Добавить группу'); ?>
    </div>
    </fieldset>

    <?php $this->endWidget(); ?>

</div><!-- form -->
