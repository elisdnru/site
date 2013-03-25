<?php
/* @var $this DAdminController */
/* @var $model BlogPost */
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(50),
    'filter'=>$model,
    'columns'=>array(
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
            'filter' => BlogCategory::model()->getTabList(),
            'value' => '$data->category ? $data->category->fullTitle : ""',
        ),
        array(
            'name' => 'author_id',
            'htmlOptions'=>array('style'=>'text-align:center'),
            'filter' => CHtml::listData(User::model()->findAll(), 'id', 'username'),
            'value' => '$data->author->username',
        ),
        array(
            'name' => 'group_id',
            'header' => 'Группа',
            'filter' => BlogPostGroup::model()->getAssocList(),
            'value' => '$data->group ? $data->group->title : ""',
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