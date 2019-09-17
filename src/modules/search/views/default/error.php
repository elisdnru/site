<?php
/* @var $this Controller */

use app\modules\main\components\Controller;
use app\modules\user\models\Access;

/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Поиск по сайту';
$this->description = 'Поиск по сайту';
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
    if ($this->moduleAllowed('new')) {
        $this->admin[] = ['label' => 'Новости', 'url' => $this->createUrl('/new/newAdmin')];
    }
    $this->info = 'Здесь собраны материалы из всех разделов';
}
?>

<h1>Поиск по сайту</h1>

<?php $this->widget(\app\modules\search\widgets\SearchFormWidget::class); ?>

<p>Введите запрос</p>
