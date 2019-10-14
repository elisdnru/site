<?php
/** @var $model \app\modules\blog\models\Post */
?>
<?php $this->reflash() ?>
<?php $this->redirect($model->getUrl());
