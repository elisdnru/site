<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'date',
            'htmlOptions' => ['style' => 'width:130px;text-align:center'],
        ],
        [
            'class' => 'DLinkColumn',
            'name' => 'title',
        ],
        [
            'name' => 'page_id',
            'filter' => NewsPage::model()->getPages($this->getUser()->accessPagesArray),
            'value' => '$data->page ? $data->page->fullTitle : ""',
        ],
        [
            'name' => 'author_id',
            'htmlOptions' => ['style' => 'text-align:center'],
            'filter' => CHtml::listData(User::model()->findAll(), 'id', 'username'),
            'value' => '$data->author ? $data->author->username : ""',
        ],
        [
            'name' => 'group_id',
            'header' => 'Группа',
            'filter' => NewsGroup::model()->getAssocList(),
            'value' => '$data->group ? $data->group->title : ""',
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
            'class' => 'DToggleColumn',
            'name' => 'inhome',
            'header' => 'Г',
            'filter' => [1 => 'На главной', 0 => 'Не на главной'],
            'titles' => [1 => 'На главной', 0 => 'Не на главной'],
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
            'offImageUrl' => Yii::app()->request->baseUrl . '/images/spacer.gif',
        ],
        [
            'class' => 'DButtonColumn',
            'template' => '{view}',
            'viewButtonUrl' => '$data->url',
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
