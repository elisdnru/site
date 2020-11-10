<?php
use app\components\SocNetwork;
use app\modules\ulogin\widgets\UloginWidget;
use app\modules\user\forms\LoginForm;
use app\modules\user\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $user User */
/** @var $model LoginForm */
?>
<?php if ($user) : ?>
    <div style="float:left;">
        <a href="<?= Url::to(['/user/profile/view']) ?>">
            <img src="<?= $user->getAvatarUrl() ?>" alt="" width="50">
        </a>
    </div>
    <div style="margin-left:60px;">
        <p class="nomargin"><strong>
                <?php if ($user->network) : ?>
                    <a href="<?= $user->identity ?>">
                        <?= SocNetwork::icon($user->network) ?>
                    </a>
                <?php endif; ?>
                <?= Html::encode($user->getFio()) ?>
            </strong>
        </p>
        <p class="nomargin">Комментариев: <?= Html::encode($user->getCommentsCount()) ?></p>
        <p class="nomargin" style="font-size:12px">
            <a href="<?= Url::to(['/user/profile/view']) ?>">Профиль</a> |
            <a href="<?= Url::to(['/user/default/logout']) ?>">Выход</a>
        </p>

        <div class="clear"></div>
    </div>

<?php else : ?>
    <?= Html::beginForm(['/user/default/login']) ?>
    <div class="login-form">

        <div class="row"><?= Html::activeTextInput($model, 'username', ['style' => 'width:100%', 'placeholder' => 'Логин или Email', 'title' => 'Логин или Email']) ?></div>
        <div class="row"><?= Html::activePasswordInput($model, 'password', ['style' => 'width:100%', 'placeholder' => 'Пароль', 'title' => 'Пароль']) ?></div>
        <div class="row" style="margin-bottom: 10px"><?= Html::activeCheckBox($model, 'rememberMe') ?></div>

        <div class="row buttons">
            <span style="font-size:12px; float: right"><a href="<?= Url::to(['/user/registration/request']) ?>">Регистрация</a> | <a href="<?= Url::to(['/user/remind/remind']) ?>">Забыли?</a></span>
            <?= Html::submitButton('Войти') ?>
            <div class="clear"></div>
        </div>

    </div>
    <?= Html::endForm() ?>
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
