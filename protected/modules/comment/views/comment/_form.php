<?php
$url = CHtml::asset(Yii::getPathOfAlias('comment.assets.comments') . '.css');
Yii::app()->clientScript->registerCssFile($url);
?>

<div id="comment-form" class="form">

    <?php $f=$this->beginWidget('CActiveForm', array(
        'action'=>'#comment-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <?php echo $f->errorSummary($form, ''); ?>

    <fieldset>
        <div class="row">
            <?php echo $f->labelEx($form,'text'); ?><br />
            <?php echo $f->textArea($form,'text',array('rows'=>20, 'cols'=>80, 'style'=>"width:99%", 'id'=>'comment_text')); ?><br />
            <?php echo $f->error($form,'text'); ?>
            <p class="coment_note">Можно использовать теги &lt;p&gt; &lt;ul&gt; &lt;li&gt; &lt;b&gt; &lt;i&gt; &lt;a&gt; &lt;pre&gt;</p>
        </div>

        <div class="row buttons">
            <br />
            <?php echo CHtml::submitButton('Сохранить комментарий', array('id'=>'comment_submit')); ?>
        </div>

    </fieldset>
    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php if(Yii::app()->user->hasFlash('commentForm')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('commentForm'); ?>
    </div>
<?php endif; ?>