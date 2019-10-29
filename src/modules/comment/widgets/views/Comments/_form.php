<?php
/** @var $user \app\modules\user\models\User */

use app\modules\comment\forms\CommentForm;
use app\modules\ulogin\widgets\UloginWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $f CActiveForm */
/** @var $form CommentForm */
?>
<!--noindex-->
<div id="comment-form" class="form">

    <?php $f = Yii::app()->controller->beginWidget(CActiveForm::class, [
        'action' => '#comment-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

    <?= $f->errorSummary($form, '') ?>

    <?php if ($user && $user->id) : ?>
        <a href="<?= Url::to(['/user/profile/view']) ?>"><img style="float:left; margin:2px 10px 0 0; width:50px" src="<?= $user->avatarUrl ?>" alt=""></a>

        <p class='exit' style="float: right">
            <a href="<?php Url::to(['/user/profile/view']); ?>">профиль</a> |
            <a href="<?= Url::to(['/user/default/logout']) ?>">выход</a>
        </p>
        <p class="nomargin">
            <?php if ($user->site) : ?>
                <a rel="nofollow" href="<?= $user->site ?>"><?= $user->fio ?></a>
            <?php else : ?>
                <?= $user->fio ?>
            <?php endif; ?>
        </p>
        <div class="clear"></div>

    <?php else : ?>
        <div style="margin-bottom: 10px">
            <div style="float: right; margin-right: -10px">
                <?= UloginWidget::widget([
                    'params' => ['redirect' => Url::to(['/ulogin/default/login', 'return' => Yii::$app->request->getUrl()], true) . '#comments', 'display' => 'panel']
                ]) ?>
            </div>
            <a href="<?= Url::to(['/user/default/login']) ?>">Войти</a> |
            <a href="<?= Url::to(['/user/registration/request']) ?>">Завести аккаунт</a> |
            <span style="color: #666">Войти через</span>
            <?php Yii::$app->user->returnUrl = Yii::$app->request->getUrl(); ?>
        </div>

        <div class="row">
            <?= $f->labelEx($form, 'name') ?><br />
            <?= $f->textField($form, 'name', ['size' => 40, 'maxlength' => 255]) ?>
            <?php //echo $f->error($form,'name'); ?>
        </div>

        <div class="row">
            <?= $f->labelEx($form, 'email') ?> (никто не увидит)<br />
            <?= $f->textField($form, 'email', ['size' => 40, 'maxlength' => 255]) ?>
            <?php //echo $f->error($form,'email'); ?>
        </div>

        <div class="row">
            <?= $f->labelEx($form, 'site') ?><br />
            <?= $f->textField($form, 'site', ['size' => 40, 'maxlength' => 255]) ?>
            <?php //echo $f->error($form,'site'); ?>
        </div>

    <?php endif; ?>

    <?= $f->hiddenField($form, 'parent_id', ['id' => 'comment-parent-id']) ?>

    <div class="row">

        <?= $f->labelEx($form, 'text') ?><br />
        <?= $f->textArea($form, 'text', ['rows' => 10, 'cols' => 80, 'style' => 'width:99%']) ?>
        <br />
        <?php //echo $f->error($form,'text'); ?>
        <p class="coment_note">Можно использовать теги &lt;p&gt; &lt;ul&gt; &lt;li&gt; &lt;b&gt; &lt;i&gt; &lt;a&gt;
            &lt;pre&gt;</p>
    </div>

    <div class="row dp3a">
        <?= $f->checkBox($form, 'yqe1') ?><?= $f->labelEx($form, 'yqe1') ?>
    </div>

    <div class="row dt1s">
        <?= $f->checkBox($form, 'yqe2') ?><?= $f->labelEx($form, 'yqe2') ?>
    </div>

    <div class="row buttons">
        <br />
        <?= CHtml::submitButton('Отправить комментарий', ['id' => 'comment_submit']) ?>
    </div>

    <?php Yii::app()->controller->endWidget(); ?>

</div>
<!--/noindex-->
