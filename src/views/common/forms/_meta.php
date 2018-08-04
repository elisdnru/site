
<fieldset>
    <h4>Мета-информация</h4>
    <div class="row">
        <?php echo $form->labelEx($model,'pagetitle'); ?><br />
        <?php echo $form->textField($model,'pagetitle',array('size'=>60, 'maxlength'=>255)); ?><br />
        <?php echo $form->error($model,'pagetitle'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?><br />
        <?php echo $form->textArea($model,'description',array('rows'=>3, 'cols'=>80)); ?><br />
        <?php echo $form->error($model,'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'keywords'); ?><br />
        <?php echo $form->textField($model,'keywords',array('size'=>60, 'maxlength'=>255)); ?><br />
        <?php echo $form->error($model,'keywords'); ?>
    </div>
</fieldset>