
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(30),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'DLinkColumn',
            'name' => 'page_id',
            'value' => '$data->page ? CHtml::encode($data->page->fullTitle) : ""',
        ),
        array(
            'name' => 'list_layout',
            'htmlOptions'=>array('style'=>'text-align:center'),
            'filter' => NewsPage::model()->getListLayouts(),
        ),
        array(
            'name' => 'show_layout',
            'htmlOptions'=>array('style'=>'text-align:center'),
            'filter' => NewsPage::model()->getShowLayouts(),
        ),
        array(
            'name' => 'show_view',
            'htmlOptions'=>array('style'=>'text-align:center'),
            'filter' => NewsPage::model()->getShowViews(),
        ),
        array(
            'class'=>'DButtonColumn',
            'template'=>'{view}',
            'viewButtonUrl'=>'$data->page ? $data->page->url : ""',

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