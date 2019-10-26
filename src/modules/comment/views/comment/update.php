<?php

use app\modules\user\models\Access;

/** @var $model \app\modules\comment\models\Comment */
/** @var $user \app\modules\user\models\User */

$this->title = 'Редактор комментариев';
$this->params['breadcrumbs'] = [
    'Редактор комментария',
];
if (Yii::app()->user->checkAccess(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('comment')) {
        $this->params['admin'][] = ['label' => 'Комментарии', 'url' => ['index']];
        $this->params['admin'][] = ['label' => 'Просмотр', 'url' => $model->url];
    }
}
?>

<h1>Редактирование комментария</h1>

<?= $this->renderPartial('_form', [
    'model' => $model,
    'form' => $form,
    'user' => $user,
]); ?>
