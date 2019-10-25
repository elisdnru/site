<?php
/** @var $this Controller */

use app\components\Controller;
use app\components\DateLimiter;
use app\components\helpers\NumberHelper;
use app\modules\user\models\Access;

/** @var $date DateLimiter */
/** @var $dataProvider CActiveDataProvider */

$this->layout = '/layouts/index';

$this->title = 'Записи за ' . $date->date . NumberHelper::pageString($dataProvider->getPagination()->pageVar);

$this->params['breadcrumbs'] = [
    'Блог' => $this->createUrl('/blog/default/index'),
    'Записи от ' . $date->date,
];

if (Yii::app()->user->checkAccess(Access::CONTROL)) {
    if (Yii::app()->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Редактировать записи', 'url' => $this->createUrl('/blog/admin/post')];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => $this->createUrl('/blog/admin/post/create')];
    }
}
?>

<h1>Записи от <?= $date->date ?></h1>

<?= $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
