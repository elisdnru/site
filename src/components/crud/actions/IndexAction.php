<?php

namespace app\components\crud\actions;

use Yii;

class IndexAction extends CrudAction
{
    /**
     * @var string view file for rendering
     */
    public $view = 'index';
    /**
     * @var string view for rendering for Ajax request
     */
    public $ajaxView = '';
    /**
     * @var string class of data provider
     */
    public $providerClass = 'CActiveDataProvider';
    /**
     * @var int items per page
     */
    public $pageSize = 10;

    public function run(): void
    {
        $model = $this->getIndexProviderModel();

        $provider = $this->providerClass;

        $dataProvider = new $provider($model, [
            'pagination' => [
                'pageSize' => $this->pageSize,
                'pageVar' => 'page',
            ]
        ]);

        if ($this->ajaxView && Yii::app()->request->isAjaxRequest) {
            $this->controller->renderPartial($this->ajaxView, [
                'dataProvider' => $dataProvider,
            ]);
        } else {
            $this->controller->render($this->view, [
                'dataProvider' => $dataProvider,
            ]);
        }
    }
}
