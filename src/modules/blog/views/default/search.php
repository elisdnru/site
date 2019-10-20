<?php
/** @var $this Controller */

use app\modules\blog\widgets\SearchFormWidget;
use app\components\Controller;
use app\components\helpers\NumberHelper;
use app\modules\user\models\Access;

/** @var $searchForm \app\modules\blog\forms\SearchForm */
/** @var $dataProvider CActiveDataProvider */

$this->layout = '/layouts/index';

$this->title = 'Поиск по записям' . NumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = '';


$this->params['breadcrumbs'] = [
    'Блог' => $this->createUrl('/blog/default/index'),
    'Поиск',
];

if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
    if (Yii::app()->moduleManager->allowed('blog')) {
        $this->admin[] = ['label' => 'Редактировать записи', 'url' => $this->createUrl('/blog/admin/post')];
        $this->admin[] = ['label' => 'Добавить запись', 'url' => $this->createUrl('/blog/admin/post/create')];
    }
}
?>

<h1>Поиск по блогу</h1>

<?php $this->widget(SearchFormWidget::class); ?>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
