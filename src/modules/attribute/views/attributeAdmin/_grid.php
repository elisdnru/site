<?php
/* @var $this DAdminController */
/* @var $model BlogPost */
?>

<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'sort',
            'htmlOptions' => ['style' => 'width:60px;text-align:center'],
        ],
        [
            'class' => 'DLinkColumn',
            'name' => 'label',
        ],
        [
            'class' => 'DLinkColumn',
            'name' => 'name',
        ],
        [
            'name' => 'class',
            'filter' => ['User' => 'Пользователь'],
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'name' => 'type',
            'value' => 'UserAttribute::getTypeName($data->type)',
            'filter' => UserAttribute::getTypes(),
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'name' => 'type',
            'value' => 'UserAttribute::getRuleName($data->rule)',
            'filter' => UserAttribute::getRules(),
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'class' => 'DToggleColumn',
            'name' => 'required',
            'header' => 'О',
            'filter' => [1 => 'Обязательный', 0 => 'Необязательный'],
            'titles' => [1 => 'Обязательный', 0 => 'Необязательный'],
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
            'offImageUrl' => Yii::app()->request->baseUrl . '/images/spacer.gif',
        ],
        [
            'class' => 'DButtonColumn',
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
            'template' => '{update}',
        ],
        [
            'class' => 'DButtonColumn',
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
            'template' => '{delete}',
        ],
    ],
]);
