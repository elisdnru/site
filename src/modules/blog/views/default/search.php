<?php
/* @var $this Controller */

use app\modules\blog\forms\SearchForm;
use app\modules\blog\widgets\BlogSearchFormWidget;
use app\components\Controller;
use app\components\helpers\NumberHelper;
use app\modules\user\models\Access;

/* @var $searchForm \app\modules\blog\forms\SearchForm */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Поиск по записям' . NumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = '';
$this->keywords = '';


$this->breadcrumbs = [
    'Блог' => $this->createUrl('/blog/default/index'),
    'Поиск',
];

if ($this->is(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Редактировать записи', 'url' => $this->createUrl('/blog/postAdmin')];
        $this->admin[] = ['label' => 'Добавить запись', 'url' => $this->createUrl('/blog/postAdmin/create')];
    }
}
?>

<h1>Поиск по блогу</h1>

<?php $this->widget(BlogSearchFormWidget::class); ?>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
