<?php
/* @var $this Controller */

use app\modules\blog\models\BlogTag;
use app\modules\main\components\Controller;
use app\modules\main\components\helpers\NumberHelper;
use app\modules\user\models\Access;

/* @var $tag BlogTag */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Записи с меткой ' . $tag->title . NumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = 'Записи с меткой ' . $tag->title . NumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->keywords = $tag->title;

Yii::app()->clientScript->registerMetaTag('noindex, follow', 'robots');

$this->breadcrumbs = [
    'Блог' => $this->createUrl('/blog/default/index'),
    'Записи с меткой «' . $tag->title . '»',
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

<h1>Записи с меткой &laquo;<?php echo CHtml::encode($tag->title); ?>&raquo;</h1>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
