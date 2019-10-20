<?php
/** @var $this Controller */

use app\modules\blog\models\Tag;
use app\components\Controller;
use app\components\helpers\NumberHelper;
use app\modules\user\models\Access;

/** @var $tag Tag */
/** @var $dataProvider CActiveDataProvider */

$this->layout = '/layouts/index';

$this->pageTitle = 'Записи с меткой ' . $tag->title . NumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = 'Записи с меткой ' . $tag->title . NumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->keywords = $tag->title;

Yii::$app->view->registerMetaTag(['name' => 'robots', 'content' => 'noindex, follow']);

$this->breadcrumbs = [
    'Блог' => $this->createUrl('/blog/default/index'),
    'Записи с меткой «' . $tag->title . '»',
];

if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
    if (Yii::app()->moduleManager->allowed('blog')) {
        $this->admin[] = ['label' => 'Редактировать записи', 'url' => $this->createUrl('/blog/admin/post')];
        $this->admin[] = ['label' => 'Добавить запись', 'url' => $this->createUrl('/blog/admin/post/create')];
    }
}
?>

<h1>Записи с меткой &laquo;<?php echo CHtml::encode($tag->title); ?>&raquo;</h1>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
