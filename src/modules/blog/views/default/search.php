<?php

use app\components\DataProvider;
use app\modules\blog\forms\SearchForm;
use app\modules\blog\widgets\SearchFormWidget;
use app\components\PaginationFormatter;
use app\modules\search\models\Search;
use app\modules\user\models\Access;
use yii\web\View;

/**
 * @var View $this
 * @var SearchForm $searchForm
 * @var DataProvider<Search> $dataProvider
 */

$this->context->layout = 'index';

$this->title = 'Поиск по записям' . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1);

$this->params['breadcrumbs'] = [
    'Блог' => ['/blog/default/index'],
    'Поиск',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('blog')) {
        $this->params['admin'][] = ['label' => 'Редактировать записи', 'url' => ['/blog/admin/post']];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => ['/blog/admin/post/create']];
    }
}
?>

<h1>Поиск по блогу</h1>

<?= SearchFormWidget::widget() ?>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]) ?>
