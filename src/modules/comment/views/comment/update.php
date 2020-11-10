<?php

use app\modules\comment\forms\CommentForm;
use app\modules\comment\models\Comment;
use app\modules\user\models\Access;
use app\modules\user\models\User;

/** @var $model Comment */
/** @var $form CommentForm */
/** @var $user User */

$this->title = 'Редактор комментариев';
$this->params['breadcrumbs'] = [
    'Редактор комментария',
];
if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('comment')) {
        $this->params['admin'][] = ['label' => 'Комментарии', 'url' => ['index']];
        $this->params['admin'][] = ['label' => 'Просмотр', 'url' => $model->getUrl()];
    }
}
?>

<h1>Редактирование комментария</h1>

<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]) ?>
