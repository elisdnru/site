<?php declare(strict_types=1);

use app\modules\comment\forms\admin\CommentUpdateForm;
use app\modules\comment\models\Comment;
use yii\web\View;

/**
 * @var View $this
 * @var Comment $comment
 * @var CommentUpdateForm $model
 */
$this->title = 'Редактор комментариев';
$this->params['breadcrumbs'] = [
    'Комментарии' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Просмотр', 'url' => ['view', 'id' => $comment->id]];
?>

<h1>Редактирование комментария</h1>

<?= $this->render('@app/modules/comment/views/admin/comment/_form', ['model' => $model, 'comment' => $comment]); ?>
