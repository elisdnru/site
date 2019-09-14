<?php
/* @var $this DController */

use app\modules\main\components\DController;
use app\modules\main\components\helpers\DNumberHelper;

/* @var $searchForm BlogSearchForm */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Поиск по записям' . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = '';
$this->keywords = '';


$this->breadcrumbs = [
    'Блог' => $this->createUrl('/blog/default/index'),
    'Поиск',
];

if ($this->is(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Редактировать записи', 'url' => $this->createUrl('/blog/postAdmin')];
    }
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Добавить запись', 'url' => $this->createUrl('/blog/postAdmin/create')];
    }
    $this->info = 'Здесь собраны записи по метке из всех разделов';
}
?>

<h1>Поиск по блогу</h1>

<?php $this->widget(BlogSearchFormWidget::class); ?>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
