<?php
$this->pageTitle = 'Редактор комментариев';
$this->breadcrumbs = [
    'Редактор комментария',
];
if ($this->is(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('comment')) {
        $this->admin[] = ['label' => 'Комментарии', 'url' => $this->createUrl('index')];
    }
    if ($this->moduleAllowed('comment')) {
        $this->admin[] = ['label' => 'Просмотр', 'url' => $model->url];
    }

    $this->info = 'Комментарии';
}
?>

<h1>Редактирование комментария</h1>

<?php $this->renderPartial('_form', [
    'model' => $model,
    'form' => $form,
    'user' => $user,
]); ?>
