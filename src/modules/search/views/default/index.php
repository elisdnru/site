<?php
/** @var $this Controller */

use app\components\Controller;
use app\components\helpers\NumberHelper;
use app\modules\user\models\Access;

/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $query CActiveRecord */

$this->title = 'Поиск по сайту' . NumberHelper::pageString($dataProvider->getPagination()->pageParam);
$this->description = 'Поиск по сайту' . NumberHelper::pageString($dataProvider->getPagination()->pageParam);
$this->keywords = '';

$this->params['breadcrumbs'] = [
    'Поиск по сайту',
];

if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
    if (Yii::app()->moduleManager->allowed('blog')) {
        $this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post')];
    }
    if (Yii::app()->moduleManager->allowed('page')) {
        $this->admin[] = ['label' => 'Страницы', 'url' => $this->createUrl('/page/admin/page')];
    }
}
?>

<h1>Поиск по сайту</h1>

<?php $this->widget(\app\modules\search\widgets\SearchFormWidget::class); ?>

<?php $this->renderPartial('_loop', [
    'dataProvider' => $dataProvider,
    'query' => $query,
]); ?>
