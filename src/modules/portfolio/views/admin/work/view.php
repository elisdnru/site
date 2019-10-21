<?php
/** @var $model Work */

use app\modules\portfolio\models\Work;

?>
<?php $this->reflash() ?>
<?php $this->redirect($model->getUrl());
