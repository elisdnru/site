<?php
$this->pageTitle = 'Модули';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Модули',
];

$this->admin[] = ['label' => 'Вернуться на сайт', 'url' => '/index'];
$this->info = 'Здесь Вы можете управлять содержимым сайта и сообщениями';

?>
    <h1>Модули</h1>

<?php $this->renderPartial('_grid', ['dataProvider' => $dataProvider]); ?>