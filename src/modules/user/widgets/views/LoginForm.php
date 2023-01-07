<?php declare(strict_types=1);

use app\components\SocNetwork;
use app\modules\ulogin\widgets\ULoginWidget;
use app\modules\user\forms\LoginForm;
use app\modules\user\models\User;
use app\modules\user\widgets\OAuthWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Request;

/**
 * @var User|null $user
 * @var LoginForm $model
 * @var Request $request
 */
?>
<?php if ($user !== null): ?>
    <div style="float:left;">
        <a href="<?= Url::to(['/user/profile/view']); ?>">
            <img src="<?= $user->getAvatarUrl(); ?>" alt="" width="50">
        </a>
    </div>
    <div style="margin-left:60px;">
        <p class="nomargin"><strong>
                <?php if ($user->network) : ?>
                    <a href="<?= $user->identity; ?>">
                        <?= SocNetwork::icon($user->network); ?>
                    </a>
                <?php endif; ?>
                <?= Html::encode($user->getFio()); ?>
            </strong>
        </p>
        <p class="nomargin">Комментариев: <?= $user->getCommentsCount(); ?></p>
        <p class="nomargin" style="font-size:12px">
            <a href="<?= Url::to(['/user/profile/view']); ?>">Профиль</a> |
            <a href="<?= Url::to(['/user/default/logout']); ?>">Выход</a>
        </p>

        <div class="clear"></div>
    </div>

<?php else: ?>
    <?= Html::beginForm(['/user/default/login']); ?>
    <div class="login-form">

        <div class="row"><?= Html::activeTextInput($model, 'username', ['style' => 'width:100%', 'placeholder' => 'Логин или Email', 'title' => 'Логин или Email']); ?></div>
        <div class="row"><?= Html::activePasswordInput($model, 'password', ['style' => 'width:100%', 'placeholder' => 'Пароль', 'title' => 'Пароль']); ?></div>
        <div class="row" style="margin-bottom: 10px"><?= Html::activeCheckBox($model, 'rememberMe'); ?></div>

        <div class="row buttons">
            <span style="font-size:12px; float: right"><a href="<?= Url::to(['/user/registration/request']); ?>">Регистрация</a> | <a href="<?= Url::to(['/user/remind/remind']); ?>">Забыли?</a></span>
            <?= Html::submitButton('Войти'); ?>
            <div class="clear"></div>
        </div>

    </div>
    <?= Html::endForm(); ?>
    <hr />
    <div style="text-align: center; padding-left:10px">
        <?php if (Yii::$app->features->isActive('OAUTH')) : ?>
            <?= OAuthWidget::widget([
                'display' => 'small',
                'return' => Yii::$app->request->getUrl(),
            ]); ?>
        <?php else: ?>
            <?= ULoginWidget::widget([
                'params' => [
                    'display' => 'small',
                    'redirect' => Url::to(['/ulogin/default/login', 'return' => ltrim($request->getUrl(), '/')], true),
                ],
            ]); ?>
        <?php endif; ?>
    </div>

<?php endif; ?>
