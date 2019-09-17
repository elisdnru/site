<?php

use app\modules\user\models\Access;

$this->pageTitle = 'Пользователи';
$this->breadcrumbs = [
    'Пользователи',
];

if ($this->is(Access::ROLE_CONTROL)) {
    $this->admin[] = ['label' => 'Пользователи', 'url' => $this->createUrl('/user/userAdmin/index')];

    $this->info = 'Управлять пользователями Вы можете в панели управления';
}

?>

<?php $this->beginWidget(\app\modules\main\components\widgets\Portlet::class, ['title' => 'Пользователи']); ?>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>

<?php $this->endWidget();

