<?php
/* @var $this DAdminController */
/* @var $model GalleryPhoto */
?>

<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(50),
    'filter' => $model,
    'columns' => [
        [
            'class' => 'DImageLinkColumn',
            'value' => '$data->getImageThumbUrl(150, 150)',
            'width' => 150,
            'height' => 150,
            'htmlOptions' => ['style' => 'width:130px;text-align:center'],
        ],
        [
            'name' => 'date',
            'htmlOptions' => ['style' => 'width:130px;text-align:center'],
        ],
        [
            'name' => 'title',
            'class' => 'DLinkColumn',
        ],
        [
            'name' => 'category_id',
            'filter' => GalleryCategory::model()->getTabList(),
            'value' => '$data->category ? $data->category->fullTitle : ""',
        ],
        [
            'class' => 'DToggleColumn',
            'name' => 'public',
            'header' => 'О',
            'filter' => [1 => 'Опубликовано', 0 => 'Не опубликовано'],
            'titles' => [1 => 'Опубликовано', 0 => 'Не опубликовано'],
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
        ],
        [
            'class' => 'DButtonColumn',
            'template' => '{view}',
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
