<?php
/* @var $this DAdminController */
/* @var $model NewsGallery */
?>

<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'alias',
            'htmlOptions' => ['style' => 'width:130px;text-align:center'],
        ],
        [
            'class' => 'DLinkColumn',
            'name' => 'title',
        ],
        [
            'class' => 'DButtonColumn',
            'template' => '{files}',
            'buttons' => [
                'files' => [
                    'url' => 'Yii::app()->controller->createUrl("files", array("id"=>$data->id))',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/admin/images.png',
                    'label' => 'Изображения',
                ]
            ]
        ],
        [
            'class' => 'DButtonColumn',
            'template' => '{update}',
        ],
        [
            'class' => 'DButtonColumn',
            'template' => '{delete}',
        ],
    ],
]);
