<?php
/** @var $this AdminController */

use app\modules\contact\models\Contact;
use app\components\AdminController;

/** @var $model Contact */

$this->pageTitle = 'Сообщения';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Сообщения',
];

if ($this->moduleAllowed('comment')) {
    $this->admin[] = ['label' => 'Комментарии', 'url' => $this->createUrl('/comment/admin/comment/index')];
}
?>

<h1>Сообщения</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>

