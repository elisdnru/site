<?php
/* @var $this DAdminController */
/* @var $model NewsGallery */

$this->pageTitle = 'Редактор фотогалереи';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Фотогалереи' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Фотогалереи', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Управление фотографиями', 'url' => $this->createUrl('files', ['id' => $model->id])];

$this->info = 'Фотогалереи';
?>

    <h1>Редактирование фотогалереи</h1>

    <p><a href="<?php echo $this->createUrl('files', ['id' => $model->id]); ?>">Управление фотографиями</a></p>

<?php $this->renderPartial('_form', ['model' => $model]); ?>