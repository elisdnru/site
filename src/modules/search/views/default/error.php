<?php
/** @var $this Controller */

use app\components\Controller;
use app\modules\user\models\Access;

/** @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Поиск по сайту';
$this->description = 'Поиск по сайту';
$this->keywords = '';

$this->breadcrumbs = [
    'Поиск по сайту',
];

if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
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

<p>Введите запрос</p>
