<?php declare(strict_types=1);

use app\assets\CommentsAsset;
use app\modules\comment\models\Comment;
use yii\web\View;

/**
 * @var View $this
 * @var Comment $comment
 */
$this->title = 'Комментарий';
$this->params['breadcrumbs'] = [
    'Комментарии' => ['index'],
    'Комментарий',
];

$this->params['admin'][] = ['label' => 'Редактировать', 'url' => ['update', 'id' => $comment->id]];
$this->params['admin'][] = ['label' => 'Комментарии', 'url' => ['index']];

CommentsAsset::register($this);
?>

<h1>Просмотр комментария</h1>

<?= $this->render('@app/modules/comment/views/admin/comment/_view', ['comment' => $comment]); ?>
