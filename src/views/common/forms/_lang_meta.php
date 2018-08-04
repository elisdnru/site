
<fieldset>
    <h4>Мета-информация</h4>
    <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
        <div class="row">
            <?php echo $form->labelEx($model,'pagetitle'); ?> <?php echo $lang; ?><br />
            <?php echo $form->textField($model,'pagetitle' . $suffix,array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'pagetitle' . $suffix); ?>
        </div>
    <?php endforeach; ?>

    <hr />

    <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
        <div class="row">
            <?php echo $form->labelEx($model,'description'); ?> <?php echo $lang; ?><br />
            <?php echo $form->textArea($model,'description' . $suffix,array('rows'=>3, 'cols'=>80)); ?><br />
            <?php echo $form->error($model,'description' . $suffix); ?>
        </div>
    <?php endforeach; ?>

    <hr />

    <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
        <div class="row">
            <?php echo $form->labelEx($model,'keywords'); ?> <?php echo $lang; ?><br />
            <?php echo $form->textField($model,'keywords' . $suffix,array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'keywords' . $suffix); ?>
        </div>
    <?php endforeach; ?>
</fieldset>