<?php
/** @var $form CActiveForm */

use app\widgets\Portlet;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $model \app\modules\contact\forms\ContactForm */
?>
<?php Portlet::begin(['title' => 'Отправить сообщение']); ?>

<div class="form">

    <form action="?" method="post">

        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

        <div class="row<?= $model->hasErrors('name') ? ' error' : '' ?><?= $model->isAttributeRequired('name') ? ' required' : '' ?>">
            <?= Html::activeLabel($model, 'name') ?><br />
            <?= Html::activeTextInput($model, 'name', ['size' => 40]) ?><br />
            <?= Html::error($model, 'name', ['class' => 'errorMessage']) ?>
        </div>

        <div class="row<?= $model->hasErrors('email') ? ' error' : '' ?><?= $model->isAttributeRequired('email') ? ' required' : '' ?>">
            <?= Html::activeLabel($model, 'email') ?><br />
            <?= Html::activeTextInput($model, 'email', ['type' => 'email', 'size' => 40]) ?><br />
            <?= Html::error($model, 'email', ['class' => 'errorMessage']) ?>
        </div>

        <div class="row<?= $model->hasErrors('phone') ? ' error' : '' ?><?= $model->isAttributeRequired('phone') ? ' required' : '' ?>">
            <?= Html::activeLabel($model, 'phone') ?><br />
            <?= Html::activeTextInput($model, 'phone', ['type' => 'tel', 'size' => 40]) ?><br />
            <?= Html::error($model, 'phone', ['class' => 'errorMessage']) ?>
        </div>

        <div class="row<?= $model->hasErrors('text') ? ' error' : '' ?><?= $model->isAttributeRequired('text') ? ' required' : '' ?>">
            <?= Html::activeLabel($model, 'text') ?><br />
            <?= Html::activeTextarea($model, 'text', ['rows' => 8, 'cols' => 50, 'style' => 'width:99%']) ?><br />
            <?= Html::error($model, 'text', ['class' => 'errorMessage']) ?>
        </div>

        <div class="row<?= $model->hasErrors('test') ? ' error' : '' ?><?= $model->isAttributeRequired('test') ? ' required' : '' ?>">
            <?= Html::activeLabel($model, 'test') ?><br />
            <?= Html::activeTextInput($model, 'test', ['size' => 22]) ?><br />
            <?= Html::error($model, 'test', ['class' => 'errorMessage']) ?>
            <div>
                <?php Captcha::widget(['buttonLabel' => '<br />Показать другой код<br />', 'captchaAction' => '/contact/default/captcha']); ?>
            </div>
        </div>

        <br />

        <div class="row<?= $model->hasErrors('accept') ? ' error' : '' ?><?= $model->isAttributeRequired('accept') ? ' required' : '' ?>">
            <?= Html::activeCheckbox($model, 'accept') ?><br />
            <?= Html::error($model, 'accept', ['class' => 'errorMessage']) ?>
        </div>

        <br />

        <div class="row buttons">
            <?= Html::submitButton('Отправить сообщение') ?>
        </div>
    </form>

</div><!-- form -->

<?php Portlet::end(); ?>
