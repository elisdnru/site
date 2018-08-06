<?php if (Yii::app()->user->hasFlash('commentForm')) : ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('commentForm'); ?>
    </div>
<?php endif; ?>

<!--noindex-->
<div id="comment-form" class="form">

    <?php $f = $this->beginWidget('CActiveForm', [
        'action' => '#comment-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <?php echo $f->errorSummary($form, ''); ?>

    <?php if ($user && $user->id) : ?>
        <a href="<?php echo $user->url; ?>"><img style="float:left; margin:2px 10px 0 0; width:50px" src="<?php echo $user->avatarUrl; ?>"/></a>

        <p class='exit floatright'><a href="<?php echo Yii::app()->createUrl('/user/profile'); ?>">профиль</a> |
            <a href="<?php echo Yii::app()->createUrl('/user/default/logout'); ?>">выход</a></p>
        <p class="nomargin">
            <?php if ($user->site) : ?>
                <a rel="nofollow" href="<?php echo $user->site; ?>"><?php echo $user->fio; ?></a>
            <?php else : ?>
                <?php echo $user->fio; ?>
            <?php endif; ?>
        </p>
        <div class="clear"></div>

    <?php else : ?>
    <div class="floatright">
        <p class="right" style="padding-right:10px">
            <span data-href="<?php echo Yii::app()->createUrl('/user/default/login'); ?>">Войти</span> |
            <span data-href="<?php echo Yii::app()->createUrl('/user/default/registration'); ?>">Завести аккаунт</span>
        </p>
        <?php $this->widget('ulogin.widgets.UloginWidget', [
            'params' => ['redirect' => Yii::app()->createAbsoluteUrl('/ulogin/default/login', ['return' => Yii::app()->request->getRequestUri()]) . '#comments', 'display' => 'panel']
        ]); ?>
        <?php Yii::app()->user->returnUrl = Yii::app()->request->requestUri; ?>
    </div>

    <fieldset>

        <div class="row">
            <?php echo $f->labelEx($form, 'name'); ?><br/>
            <?php echo $f->textField($form, 'name', ['size' => 40, 'maxlength' => 255]); ?>
            <?php //echo $f->error($form,'name'); ?>
        </div>

        <div class="row">
            <?php echo $f->labelEx($form, 'email'); ?> (никто не увидит)<br/>
            <?php echo $f->textField($form, 'email', ['size' => 40, 'maxlength' => 255]); ?>
            <?php //echo $f->error($form,'email'); ?>
        </div>

        <div class="row">
            <?php echo $f->labelEx($form, 'site'); ?><br/>
            <?php echo $f->textField($form, 'site', ['size' => 40, 'maxlength' => 255]); ?>
            <?php //echo $f->error($form,'site'); ?>
        </div>

    <?php endif; ?>

        <?php echo $f->hiddenField($form, 'parent_id', ['id' => 'comment-parent-id']); ?>

        <div class="row">

            <?php echo $f->labelEx($form, 'text'); ?><br/>
            <?php echo $f->textArea($form, 'text', ['rows' => 10, 'cols' => 80, 'style' => "width:99%", 'id' => 'comment_text']); ?>
            <br/>
            <?php //echo $f->error($form,'text'); ?>
            <p class="coment_note">Можно использовать теги &lt;p&gt; &lt;ul&gt; &lt;li&gt; &lt;b&gt; &lt;i&gt; &lt;a&gt;
                &lt;pre&gt;</p>
        </div>

        <div class="row dp3a">
            <?php echo $f->checkBox($form, 'yqe1'); ?><?php echo $f->labelEx($form, 'yqe1'); ?>
        </div>

        <div class="row dt1s">
            <?php echo $f->checkBox($form, 'yqe2'); ?><?php echo $f->labelEx($form, 'yqe2'); ?>
        </div>

        <div class="row buttons">
            <br/>
            <?php echo CHtml::submitButton('Отправить комментарий', ['id' => 'comment_submit']); ?>
        </div>

    </fieldset>
    <?php $this->endWidget(); ?>

</div>
<!--/noindex-->
