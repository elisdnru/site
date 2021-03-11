<?php

use yii\web\Session;

/**
 * @var Session $session
 */
?>

<?php if ($session->hasFlash('notice')) : ?>
    <div class="flash-notice">
        <?= (string)$session->getFlash('notice') ?>
    </div>
<?php endif; ?>

<?php if ($session->hasFlash('success')) : ?>
    <div class="flash-success">
        <?= (string)$session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if ($session->hasFlash('error')) : ?>
    <div class="flash-error">
        <?= (string)$session->getFlash('error') ?>
    </div>
<?php endif; ?>
