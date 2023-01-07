<?php declare(strict_types=1);
/**
 * @var string $display
 * @var string $fields
 * @var string $providers
 * @var string $hidden
 * @var string $redirect
 * @var string $logout_url
 */
?>
<?php if (Yii::$app->user->isGuest): ?>
    <div id="uLogin" data-ulogin="display=<?= $display; ?>;fields=<?= $fields; ?>;providers=<?= $providers; ?>;hidden=<?= $hidden; ?>;redirect_uri=<?= urlencode($redirect); ?>"></div>
<?php endif; ?>
