
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(20),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'DImageLinkColumn',
            'value' => '$data->image ? $data->getImageThumbUrl(150, 150) : ""',
            'width' => 150,
            'height' => 150,
            'htmlOptions'=>array('style'=>'width:130px;text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name' => 'title',
        ),
        array(
            'name' => 'category_id',
            'filter' => PersonnelCategory::model()->getAssocList(),
            'value' => '$data->category ? $data->category->title : ""',
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