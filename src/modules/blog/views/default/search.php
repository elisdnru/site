<?php
use app\modules\blog\forms\SearchForm;
use app\modules\blog\widgets\SearchFormWidget;
use app\components\PaginationFormatter;
use app\modules\user\models\Access;

/** @var $this \yii\web\View */
/** @var $searchForm SearchForm */
/** @var $dataProvider CActiveDataProvider */

$this->context->layout = 'index';

$this->title = 'Поиск по записям' . PaginationFormatter::appendix($dataProvider->getPagination()->getCurrentPage() + 1);

$this->params['breadcrumbs'] = [
    'Блог' => ['/blog/default/index'],
    'Поиск',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Редактировать записи', 'url' => ['/blog/admin/post']];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => ['/blog/admin/post/create']];
    }
}
?>

<h1>Поиск по блогу</h1>

<?= SearchFormWidget::widget() ?>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]); ?>
