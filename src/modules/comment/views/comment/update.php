<?php

use app\modules\user\models\Access;

$this->pageTitle = 'Редактор комментариев';
$this->breadcrumbs = [
    'Редактор комментария',
];
if ($this->is(Access::ROLE_CONTROL)) {
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
