
<?php $this->widget('DGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(30),
    'filter'=>$model,
    'columns'=>array(
        array(
            'name' => 'date',
            'htmlOptions'=>array('style'=>'width:130px;text-align:center'),
        ),
        array(
            'class' => 'DLinkColumn',
            'name' => 'title',
        ),
        array(
            'name' => 'page_id',
            'filter' => NewsPage::model()->getPages($this->getUser()->accessPagesArray),
            'value' => '$data->page ? $data->page->fullTitle : ""',
        ),
        array(
            'name' => 'author_id',
            'htmlOptions'=>array('style'=>'text-align:center'),
            'filter' => CHtml::listData(User::model()->findAll(), 'id', 'username'),
            'value' => '$data->author ? $data->author->username : ""',
        ),
        array(
            'name' => 'group_id',
            'header' => 'Группа',
            'filter' => NewsGroup::model()->getAssocList(),
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
            'class'=>'DToggleColumn',
            'name'=>'inhome',
            'header'=>'Г',
            'filter'=>array(1=>'На главной', 0=>'Не на главной'),
            'titles'=>array(1=>'На главной', 0=>'Не на главной'),
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
            'offImageUrl' => Yii::app()->request->baseUrl . '/core/images/spacer.gif',
        ),
        array(
            'class'=>'DButtonColumn',
            'htmlOptions'=>array('style'=>'width:20px;text-align:center'),
            'template'=>'{view}',
            'viewButtonUrl'=>'$data->url',
        ),
        array(
            'class'=>'DButtonColumn',
            'htmlOptions'=>array('style'=>'width:20px;text-align:center'),
            'template'=>'{update}',
        ),
        array(
            'class'=>'DButtonColumn',
            'htmlOptions'=>array('style'=>'width:20px;text-align:center'),
            'template'=>'{delete}',
        ),
    ),
)); ?>