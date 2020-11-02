<?php
use app\modules\user\models\Access;

/** @var $model \app\modules\comment\models\Comment */
/** @var $form \app\modules\comment\forms\CommentForm */
/** @var $user \app\modules\user\models\User */

$this->title = 'Редактор комментариев';
$this->params['breadcrumbs'] = [
    'Редактор комментария',
];
if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAccess->isGranted('comment')) {
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
