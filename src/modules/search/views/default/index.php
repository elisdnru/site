<?php
/* @var $this Controller */

use app\components\Controller;
use app\components\helpers\NumberHelper;
use app\modules\user\models\Access;

/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Поиск по сайту' . NumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = 'Поиск по сайту' . NumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->keywords = '';

$this->breadcrumbs = [
    'Поиск по сайту',
];

if ($this->is(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/postAdmin')];
    }
    if ($this->moduleAllowed('page')) {
        $this->admin[] = ['label' => 'Страницы', 'url' => $this->createUrl('/page/pageAdmin')];
    }
}
?>

<h1>Поиск по сайту</h1>

<?php $this->widget(\app\modules\search\widgets\SearchFormWidget::class); ?>

<?php $this->renderPartial('_loop', [
    'dataProvider' => $dataProvider,
    'query' => $query,
]); ?>
