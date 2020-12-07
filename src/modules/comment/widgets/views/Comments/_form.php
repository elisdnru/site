<?php

use app\modules\comment\forms\CommentForm;
use app\modules\ulogin\widgets\UloginWidget;
use app\modules\user\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var User $user
 * @var ActiveForm $f
 * @var CommentForm $form
 */
?>
<!--noindex-->
<div id="comment-form" class="form">

    <form action="#comment-form" method="post">

        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

        <?php if ($user && $user->id) : ?>
            <a href="<?= Url::to(['/user/profile/view']) ?>"><img style="float:left; margin:2px 10px 0 0; width:50px" src="<?= $user->getAvatarUrl() ?>" alt=""></a>

            <p class='exit' style="float: right">
                <a href="<?php Url::to(['/user/profile/view']); ?>">профиль</a> |
                <a href="<?= Url::to(['/user/default/logout']) ?>">выход</a>
            </p>
            <p class="nomargin">
                <?php if ($user->site) : ?>
                    <a rel="nofollow" href="<?= $user->site ?>"><?= $user->getFio() ?></a>
                <?php else : ?>
                    <?= $user->getFio() ?>
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

            <div class="row<?= $form->hasErrors('name') ? ' error' : '' ?><?= $form->isAttributeRequired('name') ? ' required' : '' ?>">
                <?= Html::activeLabel($form, 'name') ?><br />
                <?= Html::activeTextInput($form, 'name', ['size' => 40, 'maxlength' => 255]) ?><br />
                <?= Html::error($form, 'name', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $form->hasErrors('email') ? ' error' : '' ?><?= $form->isAttributeRequired('email') ? ' required' : '' ?>">
                <?= Html::activeLabel($form, 'email') ?> (никто не увидит)<br />
                <?= Html::activeTextInput($form, 'email', ['type' => 'email', 'size' => 40, 'maxlength' => 255]) ?><br />
                <?= Html::error($form, 'email', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $form->hasErrors('site') ? ' error' : '' ?><?= $form->isAttributeRequired('site') ? ' required' : '' ?>">
                <?= Html::activeLabel($form, 'site') ?><br />
                <?= Html::activeTextInput($form, 'site', ['type' => 'url', 'size' => 40, 'maxlength' => 255]) ?><br />
                <?= Html::error($form, 'site', ['class' => 'errorMessage']) ?>
            </div>

        <?php endif; ?>

        <?= Html::activeHiddenInput($form, 'parent_id', ['id' => 'comment-parent-id']) ?>

        <div class="row<?= $form->hasErrors('text') ? ' error' : '' ?> required">
            <?= Html::activeLabel($form, 'text') ?><br />
            <?= Html::activeTextarea($form, 'text', ['rows' => 10, 'cols' => 80, 'style' => 'width:99%']) ?><br />
            <?= Html::error($form, 'text', ['class' => 'errorMessage']) ?>
            <p class="coment_note">Можно использовать теги &lt;p&gt; &lt;ul&gt; &lt;li&gt; &lt;b&gt; &lt;i&gt; &lt;a&gt; &lt;pre&gt;</p>
        </div>

        <div class="row dp3a<?= $form->hasErrors('yqe1') ? ' error' : '' ?>">
            <?= Html::activeCheckbox($form, 'yqe1') ?>
            <?= Html::error($form, 'yqe1', ['class' => 'errorMessage']) ?>
        </div>

        <div class="row dt1s">
            <?= Html::activeCheckbox($form, 'yqe2') ?>
            <?= Html::error($form, 'yqe2', ['class' => 'errorMessage']) ?>
        </div>

        <div class="row buttons">
            <br />
            <?= Html::submitButton('Отправить комментарий', ['id' => 'comment_submit']) ?>
        </div>

    </form>

</div>
<!--/noindex-->
