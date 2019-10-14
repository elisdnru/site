<?php
/** @var $display string */
/** @var $fields string */
/** @var $providers string */
/** @var $hidden string */
/** @var $redirect string */
/** @var $logout_url string */
?>
<?php if (Yii::app()->user->isGuest) : ?>
    <div id="uLogin" data-ulogin="display=<?php echo $display ?>;fields=<?php echo $fields ?>;providers=<?php echo $providers ?>;hidden=<?php echo $hidden ?>;redirect_uri=<?php echo urlencode($redirect) ?>"></div>
<?php else : ?>
    <?php
    $anchor = 'Выйти (' . Yii::app()->user->getName() . ')';
    echo CHtml::link(CHtml::encode($anchor), []);
    ?>
<?php endif ?>
