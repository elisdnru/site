<?php

namespace app\components\crud\actions\v2;

use Yii;
use yii\base\Model;

class AdminAction extends CrudAction
{
    /**
     * @var string view file for rendering
     */
    public $view = 'admin';
    /**
     * @var string view for rendering for Ajax request
     */
    public $ajaxView = '';
    /**
     * @var string search scenarion name
     */
    public $scenario = 'search';

    public function run(): void
    {
        $model = $this->createSearchModel();

        $dataProvider = $model->search(Yii::$app->request->queryParams);

        if ($this->ajaxView && Yii::app()->request->isAjaxRequest) {
            $this->controller->renderPartial($this->ajaxView, [
                'dataProvider' => $dataProvider,
                'model' => $model,
            ]);
        } else {
            $this->controller->render($this->view, [
                'dataProvider' => $dataProvider,
                'model' => $model,
            ]);
        }
    }

    protected function createSearchModel(): Model
    {
        $this->checkMethodExists('createSearchModel');
        return $this->controller->createSearchModel();
    }
}
