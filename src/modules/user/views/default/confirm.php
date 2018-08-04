<?php
$this->pageTitle='Подтверждение регистрации';
$this->breadcrumbs = array(
    'Вход на сайт'=>$this->createUrl('login'),
    'Регистрация'=>$this->createUrl('registration'),
    'Подтверждение регистрации'
);
?>

<?php if(Yii::app()->user->hasFlash('confirm-message')): ?>

<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('confirm-message'); ?>
</div>

<?php endif; ?>
