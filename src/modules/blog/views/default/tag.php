<?php
/** @var $this Controller */

use app\modules\blog\models\Tag;
use app\components\Controller;
use app\components\helpers\NumberHelper;
use app\modules\user\models\Access;

/** @var $tag Tag */
/** @var $dataProvider CActiveDataProvider */

$this->layout = '/layouts/index';

$this->title = 'Записи с меткой ' . $tag->title . NumberHelper::pageString($dataProvider->getPagination()->pageVar);

Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => 'Записи с меткой ' . $tag->title . NumberHelper::pageString($dataProvider->getPagination()->pageVar)
]);

Yii::$app->view->registerMetaTag(['name' => 'robots', 'content' => 'noindex, follow']);

$this->params['breadcrumbs'] = [
    'Блог' => $this->createUrl('/blog/default/index'),
    'Записи с меткой «' . $tag->title . '»',
];

if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
    if (Yii::app()->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Редактировать записи', 'url' => $this->createUrl('/blog/admin/post')];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => $this->createUrl('/blog/admin/post/create')];
    }
}
?>

<h1>Записи с меткой &laquo;<?php echo CHtml::encode($tag->title); ?>&raquo;</h1>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
