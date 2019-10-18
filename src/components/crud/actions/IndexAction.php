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

        $this->controller->render($this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }
}
