<?php
use app\modules\blog\models\Tag;
use app\components\NumberHelper;
use app\modules\user\models\Access;
use yii\helpers\Html;
use yii\web\View;

/** @var $this View */
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

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Редактировать записи', 'url' => ['/blog/admin/post']];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => ['/blog/admin/post/create']];
    }
}
?>

<h1>Записи с меткой &laquo;<?= Html::encode($tag->title) ?>&raquo;</h1>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]); ?>
