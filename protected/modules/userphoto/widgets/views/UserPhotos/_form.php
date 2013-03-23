<?php if ($user->id == Yii::app()->user->id): ?>

<p><?php echo CHtml::link('Добавить фотографию', Yii::app()->createUrl('/userphoto/image/create'), array('id'=>'addPhotoLink')); ?></p>

<div style="display:none">
    <div id="addPhoto">

        <div class="form">

            <?php $form=$this->beginWidget('CActiveForm',
                array(
                    'action'=>Yii::app()->createUrl('/userphoto/image/create'),
                    'id'=>'new-form',
                    'enableClientValidation'=>false,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>false,
                    ),
                    'htmlOptions'=>array('enctype'=>'multipart/form-data')
                )
            ); ?>

            <div class="row">
                <?php echo $form->labelEx($model,'title'); ?><br />
                <?php echo $form->textField($model,'title', array('style'=>'width:200px')); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'file'); ?><br />
                <?php echo $form->fileField($model,'file', array('style'=>'width:200px')); ?>
            </div>

            <div class="row buttons"> <br />
                <?php echo CHtml::submitButton('Загрузить'); ?>
            </div>

            <?php $this->endWidget(); ?>

        </div><!-- form -->

    </div>
</div>

<script>
    jQuery('#addPhotoLink').attr('href', '#addPhoto');
    jQuery('#addPhotoLink').colorbox({
        'transition' : 'none',
        'initialWidth' : 200,
        'initialHeight' : 120,
        'innerWidth' : 250,
        'innerHeight' : 150,
        'opacity' : 0.1,
        'inline' : true
    });
</script>

<?php endif; ?>

