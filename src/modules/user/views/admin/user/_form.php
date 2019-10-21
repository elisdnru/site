<?php
/** @var $form CActiveForm */
/** @var $model \app\modules\user\models\User */
?>
<div class="form">

    <?php use app\modules\user\models\Access;

    $form = $this->beginWidget(\CActiveForm::class, [
        'id' => 'user-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
        'htmlOptions' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?php echo $form->errorSummary($model, '<b>Во время регистрации обнаружены ошибки:</b><br /><br />'); ?>

    <div>

        <fieldset>
            <h4>Аккаунт</h4>

            <div class="row">
                <?php echo $form->labelEx($model, 'username'); ?><br />
                <?php echo $form->textField($model, 'username'); ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'new_password'); ?><br />
                <?php echo $form->passwordField($model, 'new_password'); ?>
                <?php echo $form->error($model, 'new_password'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'new_confirm'); ?><br />
                <?php echo $form->passwordField($model, 'new_confirm'); ?>
                <?php echo $form->error($model, 'new_confirm'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'email'); ?><br />
                <?php echo $form->textField($model, 'email'); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
            <div class="row">
                <?php echo $form->labelEx($model, 'role'); ?><br />
                <?php echo $form->dropDownList($model, 'role', Access::getRoles()); ?><br />
                <?php echo $form->error($model, 'role'); ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Анкета</h4>

            <div class="row">
                <?php echo $form->labelEx($model, 'lastname'); ?><br />
                <?php echo $form->textField($model, 'lastname'); ?>
                <?php echo $form->error($model, 'lastname'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'name'); ?><br />
                <?php echo $form->textField($model, 'name'); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'middlename'); ?><br />
                <?php echo $form->textField($model, 'middlename'); ?>
                <?php echo $form->error($model, 'middlename'); ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Аватар</h4>
            <div class="row">
                <p><img src="<?php echo $model->avatarUrl; ?>" alt=""></p>
                <?php echo $form->labelEx($model, 'avatar'); ?><br />
                <?php echo $form->fileField($model, 'avatar', ['size' => 30]); ?><label>
                    <?php echo $form->error($model, 'avatar'); ?>
            </div>

            <div class="row">
                <?php echo $form->checkBox($model, 'del_avatar'); ?><?php echo $form->labelEx($model, 'del_avatar'); ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Дополнительные атрибуты</h4>

            <div class="row">
                <?php echo $form->labelEx($model, 'site'); ?><br />
                <?php echo $form->textField($model, 'site', ['size' => 50, 'maxlength' => 255]); ?>
                <?php echo $form->error($model, 'site'); ?>
            </div>

        </fieldset>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Сохранить'); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
