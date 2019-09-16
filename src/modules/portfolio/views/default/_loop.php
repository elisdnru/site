<?php $this->widget(\app\modules\main\components\widgets\DListView::class, [
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'id' => 'worklist',
    'afterAjaxUpdate' => 'function(){$("html, body").animate({scrollTop: $("#worklist").position().top + 250 }, 100);}',
    'htmlOptions' => [
        'class' => 'list-view greed_container'
    ],
]);
