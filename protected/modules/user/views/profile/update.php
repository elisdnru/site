<?php
$this->pageTitle='Мой профиль';
$this->breadcrumbs=array(
    'Мой профиль'=>$model->url,
    'Редактирование'
);

if ($this->is(Access::ROLE_CONTROL)){

    $this->admin[] = array('label'=>'Пользователи', 'url'=>$this->createUrl('/user/userAdmin/index'));
    $this->info = 'Управлять пользователями Вы можете в панели управления';
}?>

<?php $this->beginWidget('DPortlet', array('title' => 'Редактировать профиль'));?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'settings-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array('enctype'=>'multipart/form-data')
    )); ?>

    <?php echo $form->errorSummary($model); ?>

    <div>
        <h4>Пользователь</h4>

        <hr />
        <div class="row">
            <?php echo $form->labelEx($model,'lastname'); ?><br />
            <?php echo $form->textField($model,'lastname', array('size'=>40, 'maxlength'=>255)); ?>
            <?php echo $form->error($model,'lastname'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'name'); ?><br />
            <?php echo $form->textField($model,'name', array('size'=>40, 'maxlength'=>255)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'middlename'); ?><br />
            <?php echo $form->textField($model,'middlename', array('size'=>40, 'maxlength'=>255)); ?>
            <?php echo $form->error($model,'middlename'); ?>
        </div>

        <hr />
        <h4>Публичный профиль</h4>

        <div class="row">
            <?php echo $form->labelEx($model,'site'); ?><br />
            <?php echo $form->textField($model,'site', array('size'=>40, 'maxlength'=>255)); ?>
            <?php echo $form->error($model,'site'); ?>
        </div>

        <?php foreach (DAttributeHelper::attributes(get_class($model)) as $attr): ?>
        <div class="row">
            <?php echo $form->labelEx($model,$attr->name); ?><br />
            <?php if ($attr->type == 'text'): ?>
                <?php echo $form->textArea($model,$attr->name, array('cols'=>60, 'rows'=>3)); ?>
            <?php else: ?>
                <?php echo $form->textField($model,$attr->name, array('size'=>40, 'maxlength'=>255)); ?>
            <?php endif; ?>
            <?php echo $form->error($model,$attr->name); ?>
        </div>
        <?php endforeach; ?>

        <hr />
        <h4>Адрес и телефон</h4>
        <div class="row">
            <?php echo $form->labelEx($model,'phone'); ?><br />
            <?php echo $form->textField($model,'phone', array('size'=>40, 'maxlength'=>255)); ?>
            <?php echo $form->error($model,'phone'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'address'); ?><br />
            <?php echo $form->textArea($model,'address', array('cols'=>60, 'rows'=>3, 'maxlength'=>255)); ?>
            <?php echo $form->error($model,'address'); ?>
        </div>

        <hr />
        <h4>Аватар</h4>
        <div class="row">
            <p style="float:right"><img src="<?php echo $model->avatarUrl; ?>" alt="" width="50" height="50" /></p>
            <?php echo $form->labelEx($model,'avatar'); ?><br />
            <?php echo $form->fileField($model,'avatar', array('size'=>30)); ?><label>
            <?php echo $form->error($model,'avatar'); ?>
        </div>

        <div class="row">
            <?php echo $form->checkBox($model,'del_avatar'); ?> <?php echo $form->labelEx($model,'del_avatar'); ?>
        </div>

        <hr />
        <h4>Смена пароля</h4>
        <div class="row">
            <?php echo $form->labelEx($model,'old_password'); ?> &nbsp; (<a target="_blank" href="<?php echo $this->createUrl('/user/default/remind'); ?>">получить</a>)<br />
            <?php echo $form->passwordField($model,'old_password', array('size'=>40, 'maxlength'=>255)); ?>
            <?php echo $form->error($model,'old_password'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'new_password'); ?><br />
            <?php echo $form->passwordField($model,'new_password', array('size'=>40, 'maxlength'=>255)); ?>
            <?php echo $form->error($model,'new_password'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'new_confirm'); ?><br />
            <?php echo $form->passwordField($model,'new_confirm', array('size'=>40, 'maxlength'=>255)); ?>
            <?php echo $form->error($model,'new_confirm'); ?>
        </div>

        <hr />
        <div class="row buttons">
            <?php echo CHtml::submitButton('Сохранить'); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->


<?php $this->endWidget();?>