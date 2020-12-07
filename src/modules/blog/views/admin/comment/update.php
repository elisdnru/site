<?php
use app\modules\blog\models\Comment;
use yii\web\View;

/**
 * @var View $this
 * @var Comment $model
 */

$this->title = 'Редактор комментариев';
$this->params['breadcrumbs'] = [
    'Комментарии' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Просмотр', 'url' => ['view', 'id' => $model->id]];
?>

<h1>Редактирование комментария</h1>

<?= $this->render('@app/modules/comment/views/admin/comment/_form', ['model' => $model]) ?>
