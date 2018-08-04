<?php
/* @var $this DAdminController */
/* @var $model GalleryPhoto */
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(50),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'DImageLinkColumn',
            'value' => '$data->getImageThumbUrl(150, 150)',
            'width' => 150,
            'height' => 150,
            'htmlOptions'=>array('style'=>'width:130px;text-align:center'),
        ),
        array(
            'name'=>'date',
            'htmlOptions'=>array('style'=>'width:130px;text-align:center'),
        ),
        array(
            'name' => 'title',
            'class' => 'DLinkColumn',
        ),
        array(
            'name' => 'category_id',
            'filter' => GalleryCategory::model()->getTabList(),
            'value' => '$data->category ? $data->category->fullTitle : ""',
        ),
        array(
            'class'=>'DToggleColumn',
            'name'=>'public',
            'header'=>'О',
            'filter'=>array(1=>'Опубликовано', 0=>'Не опубликовано'),
            'titles'=>array(1=>'Опубликовано', 0=>'Не опубликовано'),
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
        ),
        array(
            'class'=>'DButtonColumn',
            'template'=>'{view}',
        ),
        array(
            'class'=>'DButtonColumn',
            'template'=>'{update}',
        ),
        array(
            'class'=>'DButtonColumn',
            'template'=>'{delete}',
        ),
    ),
)); ?>