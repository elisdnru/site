<?php
/** @var $model Work */

use app\modules\portfolio\models\Work;

?>
<?php Yii::app()->controller->reflash() ?>
<?php Yii::app()->controller->redirect($model->getUrl());
