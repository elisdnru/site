<?php
/** @var $model \app\modules\page\models\Page */
?>
<?php $this->reflash() ?>
<?php $this->redirect($model->getUrl());
