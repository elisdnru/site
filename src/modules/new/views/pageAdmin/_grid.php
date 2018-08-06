<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'class' => 'DLinkColumn',
            'name' => 'page_id',
            'value' => '$data->page ? CHtml::encode($data->page->fullTitle) : ""',
        ],
        [
            'name' => 'list_layout',
            'htmlOptions' => ['style' => 'text-align:center'],
            'filter' => NewsPage::model()->getListLayouts(),
        ],
        [
            'name' => 'show_layout',
            'htmlOptions' => ['style' => 'text-align:center'],
            'filter' => NewsPage::model()->getShowLayouts(),
        ],
        [
            'name' => 'show_view',
            'htmlOptions' => ['style' => 'text-align:center'],
            'filter' => NewsPage::model()->getShowViews(),
        ],
        [
            'class' => 'DButtonColumn',
            'template' => '{view}',
            'viewButtonUrl' => '$data->page ? $data->page->url : ""',

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
