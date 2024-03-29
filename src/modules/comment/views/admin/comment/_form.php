<?php declare(strict_types=1);

use app\components\Csrf;
use app\modules\comment\forms\admin\CommentUpdateForm;
use app\modules\comment\models\Comment;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var Comment $comment
 * @var CommentUpdateForm $model
 */
?>

<div class="form">

    <form action="?" method="post">

        <?= Csrf::hiddenInput(); ?>

        <?= Html::errorSummary($model, ['class' => 'error-summary']); ?>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить'); ?>
        </div>

        <fieldset>
            <div class="row<?= $model->hasErrors('date') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'date'); ?><br />
                <?= Html::activeTextInput($model, 'date'); ?><br />
                <?= Html::error($model, 'date', ['class' => 'error-message']); ?>
            </div>

            <div class="row<?= $model->hasErrors('parent_id') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'parent_id'); ?><br />
                <?= Html::activeTextInput($model, 'parent_id'); ?><br />
                <?= Html::error($model, 'parent_id', ['class' => 'error-message']); ?>
            </div>

            <?php if ($comment->user): ?>
                <p class="nomargin">
                    <a href="<?= Url::to(['/user/admin/user/update', 'id' => $comment->user_id]); ?>"><?= $comment->user->getFio(); ?></a>
                </p>
            <?php else: ?>
                <div class="row<?= $model->hasErrors('name') ? ' error' : ''; ?>">
                    <?= Html::activeLabel($model, 'name'); ?><br />
                    <?= Html::activeTextInput($model, 'name'); ?><br />
                    <?= Html::error($model, 'name', ['class' => 'error-message']); ?>
                </div>

                <div class="row<?= $model->hasErrors('email') ? ' error' : ''; ?>">
                    <?= Html::activeLabel($model, 'email'); ?><br />
                    <?= Html::activeTextInput($model, 'email', ['type' => 'email']); ?><br />
                    <?= Html::error($model, 'email', ['class' => 'error-message']); ?>
                </div>

                <div class="row<?= $model->hasErrors('site') ? ' error' : ''; ?>">
                    <?= Html::activeLabel($model, 'site'); ?><br />
                    <?= Html::activeTextInput($model, 'site', ['type' => 'url']); ?><br />
                    <?= Html::error($model, 'site', ['class' => 'error-message']); ?>
                </div>
            <?php endif; ?>
        </fieldset>

        <fieldset class="editor">
            <div class="row<?= $model->hasErrors('text') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'text'); ?><br />
                <?= Html::activeTextarea($model, 'text', ['rows' => 20, 'cols' => 80]); ?><br />
                <?= Html::error($model, 'text', ['class' => 'error-message']); ?>
            </div>
        </fieldset>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить'); ?>
        </div>

    </form>

</div><!-- form -->
