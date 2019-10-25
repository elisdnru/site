<?php
/** @var $model Landing */
use app\modules\landing\models\Landing;
?>
<?php $this->reflash() ?>
<?php $this->redirect($model->getUrl());
