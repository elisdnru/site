<?php
/**
 * @var string $display
 * @var string $fields
 * @var string $providers
 * @var string $hidden
 * @var string $redirect
 * @var string $logout_url
 */
?>
<?php if (Yii::$app->user->isGuest) : ?>
    <div id="uLogin" data-ulogin="display=<?php echo $display ?>;fields=<?php echo $fields ?>;providers=<?php echo $providers ?>;hidden=<?php echo $hidden ?>;redirect_uri=<?php echo urlencode($redirect) ?>"></div>
<?php endif; ?>
