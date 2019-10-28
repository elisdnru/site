<?php
use app\components\helpers\SocNetworkHelper;
use app\modules\ulogin\widgets\UloginWidget;
use yii\helpers\Url;

/** @var $user \app\modules\user\models\User */
/** @var $model \app\modules\user\forms\LoginForm */
?>
<?php if ($user) : ?>
    <div style="float:left;">
        <a href="<?= Url::to(['/user/profile/view']) ?>">
            <img src="<?= $user->avatarUrl ?>" alt="" width="50">
        </a>
    </div>
    <div style="margin-left:60px;">
        <p class="nomargin"><strong>
                <?php if ($user->network) : ?>
                    <a href="<?= $user->identity ?>">
                        <?= SocNetworkHelper::getIcon($user->network) ?>
                    </a>
                <?php endif; ?>
                <?= CHtml::encode($user->fio) ?>
            </strong>
        </p>
        <p class="nomargin">Комментариев: <?= CHtml::encode($user->commentsCount) ?></p>
        <p class="nomargin" style="font-size:12px">
            <a href="<?= Url::to(['/user/profile/view']) ?>">Профиль</a> |
            <a href="<?= Url::to(['/user/default/logout']) ?>">Выход</a>
        </p>

        <div class="clear"></div>
    </div>

<?php else : ?>
    <?= CHtml::beginForm(['/user/default/login']) ?>
    <div class="login-form">

        <div class="row"><?= CHtml::activeTextField($model, 'username', ['style' => 'width:100%', 'placeholder' => 'Логин или Email', 'title' => 'Логин или Email']) ?></div>
        <div class="row"><?= CHtml::activePasswordField($model, 'password', ['style' => 'width:100%', 'placeholder' => 'Пароль', 'title' => 'Пароль']) ?></div>
        <div class="row" style="margin-bottom: 10px"><label><?= CHtml::activeCheckBox($model, 'rememberMe') ?> Запомнить меня</label></div>

        <div class="row buttons">
            <span style="font-size:12px; float: right"><a href="<?= Url::to(['/user/registration/request']) ?>">Регистрация</a> | <a href="<?= Yii::app()->createUrl('/user/default/remind') ?>">Забыли?</a></span>
            <?= CHtml::submitButton('Войти') ?>
            <div class="clear"></div>
        </div>

    </div>
    <?= CHtml::endForm() ?>
    <hr />
    <div style="text-align: center; padding-left:10px">
        <?= UloginWidget::widget([
            'params' => [
                'display' => 'small',
                'redirect' => Url::to(['/ulogin/default/login', 'return' => ltrim(Yii::$app->request->getUrl(), '/')], true)
            ]
        ]) ?>
    </div>

<?php endif; ?>
