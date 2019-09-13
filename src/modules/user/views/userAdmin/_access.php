<div class="form">

    <?php $form = $this->beginWidget(\CActiveForm::class, [
        'action' => $this->createUrl('accessadd', ['id' => $model->id]),
        'id' => 'page-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <?php echo CHtml::beginForm(); ?>

    <fieldset>

        <div class="row">
            <?php echo $form->labelEx($model, 'access_pages'); ?><br /><br />
            <table class="grid">
                <?php foreach ($model->access_pages as $item) :
                    $delurl = $this->createUrl('accessdel', ['id' => $item->id]);

                    ?>
                    <tr id="item_<?php echo $item->id; ?>">
                        <td><?php echo $item->page->getFullTitle(); ?></td>
                        <td width="16" class="center">
                            <a class="ajax_del" data-del="item_<?php echo $item->id; ?>" title="Удалить доступ" href="<?php echo $delurl; ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить" /></a>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </table>
        </div>

        <div class="row">
            <?php echo CHtml::dropDownList('AccessPage[page]', '', Page::model()->getAssocList()); ?>
        </div>
        <div class="row buttons">
            <?php echo CHtml::submitButton('Добавить'); ?>
        </div>
    </fieldset>

    <?php $this->endWidget(); ?>

</div><!-- form -->
