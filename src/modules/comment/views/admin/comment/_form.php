<?php
/** @var $this AdminController */

use app\modules\comment\models\Comment;
use app\components\AdminController;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $model Comment */
/** @var $form CActiveForm */
?>

<div class="form">

    <form action="?" method="post" enctype="multipart/form-data">

        <?= Html::hiddenInput(Yii::app()->request->csrfTokenName, Yii::app()->request->getCsrfToken()) ?>

        <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

        <?= Html::errorSummary($model, ['class' => 'errorSummary']) ?>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить') ?>
        </div>

        <fieldset>
            <div class="row<?= $model->hasErrors('date') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'date') ?><br />
                <?= Html::activeTextInput($model, 'date') ?><br />
                <?= Html::error($model, 'date', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('parent_id') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'parent_id') ?><br />
                <?= Html::activeTextInput($model, 'parent_id') ?><br />
                <?= Html::error($model, 'parent_id', ['class' => 'errorMessage']) ?>
            </div>

            <?php if ($model->user) : ?>
                <p class="nomargin">
                    <a href="<?= Url::to(['/user/admin/user/update', 'id' => $model->user_id]) ?>"><?= $model->user->fio ?></a>
                </p>
            <?php else : ?>

                <div class="row<?= $model->hasErrors('name') ? ' error' : '' ?>">
                    <?= Html::activeLabel($model, 'name') ?><br />
                    <?= Html::activeTextInput($model, 'name') ?><br />
                    <?= Html::error($model, 'name', ['class' => 'errorMessage']) ?>
                </div>

                <div class="row<?= $model->hasErrors('email') ? ' error' : '' ?>">
                    <?= Html::activeLabel($model, 'email') ?><br />
                    <?= Html::activeTextInput($model, 'email', ['type' => 'email']) ?><br />
                    <?= Html::error($model, 'email', ['class' => 'errorMessage']) ?>
                </div>

                <div class="row<?= $model->hasErrors('site') ? ' error' : '' ?>">
                    <?= Html::activeLabel($model, 'site') ?><br />
                    <?= Html::activeTextInput($model, 'site', ['type' => 'url']) ?><br />
                    <?= Html::error($model, 'site', ['class' => 'errorMessage']) ?>
                </div>
            <?php endif; ?>
        </fieldset>

        <fieldset class="editor">
            <div class="row<?= $model->hasErrors('text') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'text') ?><br />
                <?= Html::activeTextarea($model, 'text', ['rows' => 20, 'cols' => 80]) ?><br />
                <?= Html::error($model, 'text', ['class' => 'errorMessage']) ?>
            </div>
        </fieldset>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить') ?>
        </div>

    </form>

</div><!-- form -->
