<?php
/* @var $this Controller */

use app\components\Controller;
use app\components\DateLimiter;
use app\components\helpers\NumberHelper;
use app\modules\user\models\Access;

/* @var $date DateLimiter */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Записи за ' . $date->date . NumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = '';
$this->keywords = '';


$this->breadcrumbs = [
    'Блог' => $this->createUrl('/blog/default/index'),
    'Записи от ' . $date->date,
];

if ($this->is(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Редактировать записи', 'url' => $this->createUrl('/blog/postAdmin')];
        $this->admin[] = ['label' => 'Добавить запись', 'url' => $this->createUrl('/blog/admin/post/create')];
    }
}
?>

<h1>Записи от <?php echo $date->date; ?></h1>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
