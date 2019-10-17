<?php

use app\modules\user\models\Access;

/** @var $model \app\modules\comment\models\Comment */
/** @var $user \app\modules\user\models\User */

$this->pageTitle = 'Редактор комментариев';
$this->breadcrumbs = [
    'Редактор комментария',
];
if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('comment')) {
        $this->admin[] = ['label' => 'Комментарии', 'url' => $this->createUrl('index')];
        $this->admin[] = ['label' => 'Просмотр', 'url' => $model->url];
    }
}
?>

<h1>Редактирование комментария</h1>

<?php $this->renderPartial('_form', [
    'model' => $model,
    'form' => $form,
    'user' => $user,
]); ?>
