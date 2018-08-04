<?php
$this->pageTitle='Редактор комментариев';
$this->breadcrumbs=array(
	'Редактор комментария',
);
if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('comment')) $this->admin[] = array('label'=>'Комментарии', 'url'=>$this->createUrl('index'));
    if ($this->moduleAllowed('comment')) $this->admin[] = array('label'=>'Просмотр', 'url'=>$model->url);

    $this->info = 'Комментарии';
}
?>

<h1>Редактирование комментария</h1>

<?php $this->renderPartial('_form', array(
    'model'=>$model,
    'form'=>$form,
    'user'=>$user,
)); ?>
