<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'user-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array('enctype'=>'multipart/form-data')
    )); ?>

    <?php if(Yii::app()->user->hasFlash('register-form')): ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('register-form'); ?>
    </div>

    <?php endif; ?>

    <?php echo $form->errorSummary($model,'<b>Во время регистрации обнаружены ошибки:</b><br /><br />'); ?>

    <div>

        <fieldset>
            <h4>Аккаунт</h4>

            <div class="row">
                <?php echo $form->labelEx($model,'username'); ?><br />
                <?php echo $form->textField($model,'username'); ?>
                <?php echo $form->error($model,'username'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'new_password'); ?><br />
                <?php echo $form->passwordField($model,'new_password'); ?>
                <?php echo $form->error($model,'new_password'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'new_confirm'); ?><br />
                <?php echo $form->passwordField($model,'new_confirm'); ?>
                <?php echo $form->error($model,'new_confirm'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'email'); ?><br />
                <?php echo $form->textField($model,'email'); ?>
                <?php echo $form->error($model,'email'); ?>
            </div>
            <div class="row">
                <?php echo $form->labelEx($model,'role'); ?><br />
                <?php echo $form->dropDownList($model,'role', Access::getRoles()); ?><br />
                <?php echo $form->error($model,'role'); ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Анкета</h4>

            <div class="row">
                <?php echo $form->labelEx($model,'lastname'); ?><br />
                <?php echo $form->textField($model,'lastname'); ?>
                <?php echo $form->error($model,'lastname'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'name'); ?><br />
                <?php echo $form->textField($model,'name'); ?>
                <?php echo $form->error($model,'name'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'middlename'); ?><br />
                <?php echo $form->textField($model,'middlename'); ?>
                <?php echo $form->error($model,'middlename'); ?>
            </div>
        </fieldset>

        <fieldset>
        <h4>Аватар</h4>
        <div class="row">
            <p><img src="<?php echo $model->avatarUrl; ?>" alt="" /></p>
            <?php echo $form->labelEx($model,'avatar'); ?><br />
            <?php echo $form->fileField($model,'avatar', array('size'=>30)); ?><label>
            <?php echo $form->error($model,'avatar'); ?>
        </div>

        <div class="row">
            <?php echo $form->checkBox($model,'del_avatar'); ?> <?php echo $form->labelEx($model,'del_avatar'); ?>
        </div>
        </fieldset>

        <fieldset>
        <h4>Дополнительные атрибуты</h4>

        <div class="row">
            <?php echo $form->labelEx($model,'site'); ?><br />
            <?php echo $form->textField($model,'site', array('size'=>50, 'maxlength'=>255)); ?>
            <?php echo $form->error($model,'site'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'googleplus'); ?><br />
            <?php echo $form->textField($model,'googleplus', array('size'=>50, 'maxlength'=>255)); ?>
            <?php echo $form->error($model,'googleplus'); ?>
        </div>

        <?php foreach (DAttributeHelper::attributes(get_class($model)) as $attr): ?>
        <div class="row">
            <?php echo $form->labelEx($model,$attr->name); ?><br />
            <?php if ($attr->type == 'text'): ?>
                <?php echo $form->textArea($model,$attr->name, array('rows'=>5)); ?>
            <?php else: ?>
                <?php echo $form->textField($model,$attr->name, array('size'=>50, 'maxlength'=>255)); ?>
            <?php endif; ?>
            <?php echo $form->error($model,$attr->name); ?>
        </div>
        <?php endforeach; ?>
        </fieldset>

        <fieldset>
            <h4>Адрес и телефон</h4>

            <div class="row">
                <?php echo $form->labelEx($model,'zip'); ?><br />
                <?php echo $form->textField($model,'zip'); ?>
                <?php echo $form->error($model,'zip'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'address'); ?><br />
                <?php echo $form->textArea($model,'address', array('cols'=>60, 'rows'=>3, 'maxlength'=>255)); ?>
                <?php echo $form->error($model,'address'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'phone'); ?><br />
                <?php echo $form->textField($model,'phone'); ?>
                <?php echo $form->error($model,'phone'); ?>
            </div>
        </fieldset>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Сохранить'); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->