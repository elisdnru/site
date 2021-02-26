<?php

use app\components\Csrf;
use app\modules\comment\forms\CommentForm;
use yii\helpers\Html;

/**
 * @var CommentForm $form
 */
?>
<div class="form">

    <form action="?" method="post" id="comment-form">
        <?= Csrf::hiddenInput() ?>

        <fieldset>

            <div class="row<?= $form->hasErrors('text') ? ' error' : '' ?>">
                <?= Html::activeLabel($form, 'text') ?><br />
                <?= Html::activeTextarea($form, 'text', ['rows' => 20, 'cols' => 80, 'style' => 'width:99%']) ?><br />
                <?= Html::error($form, 'text', ['class' => 'errorMessage']) ?>
                <p class="coment-note">Можно использовать теги &lt;p&gt; &lt;ul&gt; &lt;li&gt; &lt;b&gt; &lt;i&gt; &lt;a&gt; &lt;pre&gt;</p>
            </div>

            <div class="row buttons">
                <br />
                <?= Html::submitButton('Сохранить комментарий', ['id' => 'comment_submit']) ?>
            </div>

        </fieldset>
    </form>

</div><!-- form -->
