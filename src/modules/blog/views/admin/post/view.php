<?php
/** @var $model \app\modules\blog\models\Post */
?>
<?php $this->context->reflash() ?>
<?php $this->redirect($model->getUrl());
