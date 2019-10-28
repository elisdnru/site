<?php if (Yii::$app->session->hasFlash('notice')) : ?>
    <div class="flash-notice">
        <?= Yii::$app->session->getFlash('notice') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('success')) : ?>
    <div class="flash-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')) : ?>
    <div class="flash-error">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>
