<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'name' => 'name',
            'header' => 'Имя',
        ],
        [
            'name' => 'group',
            'header' => 'Группа',
        ],
        [
            'class' => 'DToggleColumn',
            'header' => 'Установлен',
            'name' => 'installed',
            'confirmation' => 'Установить/Удалить модуль?',
            'titles' => [1 => 'Установлен', 0 => 'Не установлен'],
            'linkUrl' => 'Yii::app()->controller->createUrl("toggleInstalled", array("module"=>$data["id"]))',
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
        ],
        [
            'class' => 'DToggleColumn',
            'header' => 'Активен',
            'name' => 'active',
            'titles' => [1 => 'Активен', 0 => 'Не активен'],
            'linkUrl' => 'Yii::app()->controller->createUrl("toggleActive", array("module"=>$data["id"]))',
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
        ],
    ],
]);
