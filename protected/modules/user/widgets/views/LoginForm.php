<?php if ($user): ?>

<div style="float:left;">
    <a href="<?php echo $user->url; ?>">
        <img src="<?php echo $user->avatarUrl; ?>" alt="" width="50" />
    </a>
</div>
<div style="margin-left:60px;">
    <p class="nomargin"><strong>
        <?php if ($user->network): ?>
        <a rel="nofollow" href="<?php echo $user->identity; ?>"><img style="vertical-align: middle" src="<?php echo DSocNetworkHelper::getIcon($user->network); ?>" /></a>
        <?php endif; ?>
        <?php echo CHtml::encode($user->fio); ?>
    </strong>
    </p>
    <?php if ($user->comments_count): ?><p class="nomargin">Комментариев: <?php echo CHtml::encode($user->comments_count); ?></p><?php endif; ?>
    <p class="nomargin" style="font-size:12px">
        <a href="<?php echo $user->url; ?>">Профиль</a> |
        <a href="<?php echo Yii::app()->createUrl('/user/default/logout'); ?>">Выход</a>
    </p>

    <div class="clear"></div>
</div>

<?php else : ?>

<?php echo CHtml::beginForm(array('/user/default/login')); ?>
<div id="login-side-form" class="form">

    <div class="row"><?php echo CHtml::activeTextField($model, 'username', array('style'=>'width:95%', 'placeholder'=>'Логин или Email', 'title'=>'Логин или Email')); ?></div>
    <div class="row"><?php echo CHtml::activePasswordField($model, 'password', array('style'=>'width:95%', 'placeholder'=>'Пароль', 'title'=>'Пароль')); ?></div>

    <div class="row buttons">
        <span class="right floatright" style="font-size:12px"><a href="<?php echo Yii::app()->createUrl('/user/default/registration'); ?>">Регистрация</a> | <a href="<?php echo Yii::app()->createUrl('/user/default/remind'); ?>">Забыли?</a></span>
        <?php echo CHtml::submitButton("Войти"); ?>
        <div class="clear"></div>
    </div>

</div>
<?php echo CHtml::endForm(); ?>
<hr />
<div class="center" style="padding-left:10px">
    <?php  $this->widget('ulogin.widgets.UloginWidget', array(
    'params'=>array(
        'display'=>'small',
        'redirect'=>Yii::app()->createAbsoluteUrl('/ulogin/default/login', array('return'=>ltrim(DLanguageUrlHelper::getRequestUri(), '/')))
    )
)); ?>
</div>

<?php endif; ?>