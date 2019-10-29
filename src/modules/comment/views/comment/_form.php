<?php
use app\modules\comment\forms\CommentForm;
use yii\helpers\Html;

/** @var $f CActiveForm */
/** @var $form CommentForm */
?>
<div id="comment-form" class="form">

    <?php $f = Yii::app()->controller->beginWidget(CActiveForm::class, [
        'action' => '#comment-form',
        'enableClientValidation' => false,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

    <?= $f->errorSummary($form, '') ?>

    <fieldset>
        <div class="row">
            <?= $f->labelEx($form, 'text') ?><br />
            <?= $f->textArea($form, 'text', ['rows' => 20, 'cols' => 80, 'style' => 'width:99%']) ?>
            <br />
            <?= $f->error($form, 'text') ?>
            <p class="coment_note">Можно использовать теги &lt;p&gt; &lt;ul&gt; &lt;li&gt; &lt;b&gt; &lt;i&gt; &lt;a&gt;
                &lt;pre&gt;</p>
        </div>

        <div class="row buttons">
            <br />
            <?= Html::submitButton('Сохранить комментарий', ['id' => 'comment_submit']) ?>
        </div>

    </fieldset>
    <?php Yii::app()->controller->endWidget(); ?>

</div><!-- form -->
