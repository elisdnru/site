<?php
/** @var $this \yii\web\View */

use app\modules\blog\models\Tag;
use app\components\Controller;
use app\components\helpers\NumberHelper;
use app\modules\user\models\Access;

/** @var $tag Tag */
/** @var $dataProvider CActiveDataProvider */

$this->context->layout = 'index';

$this->title = 'Записи с меткой ' . $tag->title . NumberHelper::pageString($dataProvider->getPagination()->pageVar);

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Записи с меткой ' . $tag->title . NumberHelper::pageString($dataProvider->getPagination()->pageVar)
]);

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex, follow']);

$this->params['breadcrumbs'] = [
    'Блог' => ['/blog/default/index'],
    'Записи с меткой «' . $tag->title . '»',
];

if (Yii::app()->user->checkAccess(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Редактировать записи', 'url' => ['/blog/admin/post']];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => ['/blog/admin/post/create']];
    }
}
?>

<h1>Записи с меткой &laquo;<?= CHtml::encode($tag->title) ?>&raquo;</h1>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]); ?>
