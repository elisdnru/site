<?php
/* @var $this DAdminController */
/* @var $model ShopProduct */
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'DImageLinkColumn',
            'value' => '$data->firstImage ? $data->firstImage->getThumbUrl(150, 150) : ""',
            'width' => 150,
            'height' => 150,
            'htmlOptions'=>array('style'=>'width:130px;text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name' => 'artikul',
            'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name' => 'title',
            'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'name' => 'type_id',
            'filter' => ShopType::model()->getAssocList(),
            'htmlOptions'=>array('style'=>'text-align:center'),
            'value' => '$data->type ? $data->type->title : ""',
        ),
        array(
            'name' => 'category_id',
            'filter' => ShopCategory::model()->type($model->type_id)->getTabList(),
            'htmlOptions'=>array('style'=>'text-align:center'),
            'value' => '$data->category ? $data->category->getFullTitle("/<br />") : ""',
        ),
        array(
            'name' => 'brand_id',
            'filter' => ShopBrand::model()->getAssocList(),
            'htmlOptions'=>array('style'=>'text-align:center'),
            'value' => '$data->brand ? $data->brand->title : ""',
        ),
        array(
            'name' => 'price',
            'value' => 'number_format($data->price, 0, ".", " ")',
            'htmlOptions'=>array('style'=>'width:50px;text-align:center'),
        ),
        array(
            'name' => 'priority',
            'value' => '$data->priority',
            'htmlOptions'=>array('style'=>'width:50px;text-align:center'),
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
            'offImageUrl'=>Yii::app()->request->baseUrl . '/core/images/spacer.gif',
        ),
        array(
            'class'=>'DToggleColumn',
            'name'=>'popular',
            'header'=>'П',
            'filter'=>array(1=>'Популярные', 0=>'Не популярные'),
            'titles'=>array(1=>'Популярный', 0=>'Не популярный'),
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
            'offImageUrl'=>Yii::app()->request->baseUrl . '/core/images/spacer.gif',
        ),
        array(
            'class'=>'DToggleColumn',
            'name'=>'sale',
            'header'=>'А',
            'filter'=>array(1=>'Акция', 0=>'Без акции'),
            'titles'=>array(1=>'Акция', 0=>'Без акции'),
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
            'offImageUrl'=>Yii::app()->request->baseUrl . '/core/images/spacer.gif',
        ),
        array(
            'class'=>'DButtonColumn',
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
            'template'=>'{view}<br /><br />{update}<br /><br />{copy}<br /><br />{delete}',
            'buttons'=>array(
                'copy'=>array(
                    'imageUrl'=>Yii::app()->request->baseUrl.'/core/images/admin/copy.png',
                    'url'=>'Yii::app()->controller->createUrl("create", array("id"=>$data->id))',
                    'label'=>'Клонировать',
                )
            )
        ),
    ),
)); ?>