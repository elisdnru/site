<?php if (Yii::app()->user->hasFlash('notice')) : ?>
    <div class="flash-notice">
        <?= Yii::app()->user->getFlash('notice') ?>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('success')) : ?>
    <div class="flash-success">
        <?= Yii::app()->user->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('error')) : ?>
    <div class="flash-error">
        <?= Yii::app()->user->getFlash('error') ?>
    </div>
<?php endif; ?>
