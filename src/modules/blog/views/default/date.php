<?php
/* @var $this DController */

use app\modules\main\components\DController;
use app\modules\main\components\DDateLimiter;
use app\modules\main\components\helpers\DNumberHelper;

/* @var $date DDateLimiter */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Записи за ' . $date->date . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = '';
$this->keywords = '';


$this->breadcrumbs = [
    'Блог' => $this->createUrl('/blog/default/index'),
    'Записи от ' . $date->date,
];

if ($this->is(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Редактировать записи', 'url' => $this->createUrl('/blog/postAdmin')];
    }
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Добавить запись', 'url' => $this->createUrl('/blog/postAdmin/create')];
    }
    $this->info = 'Здесь собраны записи по дате';
}
?>

<h1>Записи от <?php echo $date->date; ?></h1>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
