<fieldset>
    <h4>Мета-информация</h4>
    <div class="row">
        <?php echo $form->labelEx($model, 'pagetitle'); ?><br/>
        <?php echo $form->textField($model, 'pagetitle', ['size' => 60, 'maxlength' => 255]); ?><br/>
        <?php echo $form->error($model, 'pagetitle'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?><br/>
        <?php echo $form->textArea($model, 'description', ['rows' => 3, 'cols' => 80]); ?><br/>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'keywords'); ?><br/>
        <?php echo $form->textField($model, 'keywords', ['size' => 60, 'maxlength' => 255]); ?><br/>
        <?php echo $form->error($model, 'keywords'); ?>
    </div>
</fieldset>
