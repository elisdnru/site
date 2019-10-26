<?php
/** @var $model Page */

use app\modules\page\models\Page;

?>
<?php $this->context->reflash() ?>
<?php $this->redirect($model->getUrl());
