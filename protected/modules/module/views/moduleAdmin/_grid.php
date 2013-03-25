
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        array(
            'name' => 'name',
            'header' => 'Имя',
        ),
        array(
            'name' => 'group',
            'header' => 'Группа',
        ),
        array(
            'class'=>'DToggleColumn',
            'header'=>'Установлен',
            'name'=>'installed',
            'confirmation'=>'Установить/Удалить модуль?',
            'titles'=>array(1=>'Установлен', 0=>'Не установлен'),
            'linkUrl'=>'Yii::app()->controller->createUrl("toggleInstalled", array("module"=>$data["id"]))',
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
        ),
        array(
            'class'=>'DToggleColumn',
            'header'=>'Активен',
            'name'=>'active',
            'titles'=>array(1=>'Активен', 0=>'Не активен'),
            'linkUrl'=>'Yii::app()->controller->createUrl("toggleActive", array("module"=>$data["id"]))',
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
        ),
    ),
)); ?>