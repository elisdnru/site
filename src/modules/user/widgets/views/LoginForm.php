<?php
use app\components\helpers\SocNetworkHelper;
/** @var $user \app\modules\user\models\User */
/** @var $model \app\modules\user\forms\LoginForm */
?>
<?php if ($user) : ?>
    <div style="float:left;">
        <a href="<?php echo Yii::app()->createUrl('/user/profile/view'); ?>">
            <img src="<?php echo $user->avatarUrl; ?>" alt="" width="50">
        </a>
    </div>
    <div style="margin-left:60px;">
        <p class="nomargin"><strong>
                <?php if ($user->network) : ?>
                    <a href="<?php echo $user->identity; ?>">
                        <?php echo SocNetworkHelper::getIcon($user->network); ?>
                    </a>
                <?php endif; ?>
                <?php echo CHtml::encode($user->fio); ?>
            </strong>
        </p>
        <?php if ($user->comments_count) :
            ?><p class="nomargin">
            Комментариев: <?php echo CHtml::encode($user->comments_count); ?></p><?php
        endif; ?>
        <p class="nomargin" style="font-size:12px">
            <a href="<?php echo Yii::app()->createUrl('/user/profile/view'); ?>">Профиль</a> |
            <a href="<?php echo Yii::app()->createUrl('/user/default/logout'); ?>">Выход</a>
        </p>

        <div class="clear"></div>
    </div>

<?php else : ?>
    <?php echo CHtml::beginForm(['/user/default/login']); ?>
    <div class="login-form">

        <div class="row"><?php echo CHtml::activeTextField($model, 'username', ['style' => 'width:100%', 'placeholder' => 'Логин или Email', 'title' => 'Логин или Email']); ?></div>
        <div class="row"><?php echo CHtml::activePasswordField($model, 'password', ['style' => 'width:100%', 'placeholder' => 'Пароль', 'title' => 'Пароль']); ?></div>
        <div class="row" style="margin-bottom: 10px"><label><?php echo CHtml::activeCheckBox($model, 'rememberMe'); ?> Запомнить меня</label></div>

        <div class="row buttons">
            <span style="font-size:12px; float: right"><a href="<?php echo Yii::app()->createUrl('/user/default/registration'); ?>">Регистрация</a> | <a href="<?php echo Yii::app()->createUrl('/user/default/remind'); ?>">Забыли?</a></span>
            <?php echo CHtml::submitButton('Войти'); ?>
            <div class="clear"></div>
        </div>

    </div>
    <?php echo CHtml::endForm(); ?>
    <hr />
    <div style="text-align: center; padding-left:10px">
        <?php $this->widget(\app\modules\ulogin\widgets\UloginWidget::class, [
            'params' => [
                'display' => 'small',
                'redirect' => Yii::app()->createAbsoluteUrl('/ulogin/default/login', ['return' => ltrim(Yii::app()->getRequest()->getRequestUri(), '/')])
            ]
        ]); ?>
    </div>

<?php endif; ?>
