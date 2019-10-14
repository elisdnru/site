<?php

namespace app\components\crud\actions;

use Yii;

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
        $model = $this->createModel();

        $formName = (new \ReflectionObject($model))->getShortName();

        $modelName = get_class($this->createModel());

        $model = new $modelName($this->scenario);

        $model->unsetAttributes();
        if (isset($_GET[$formName])) {
            $model->attributes = $_GET[$formName];
        }

        if ($this->ajaxView && Yii::app()->request->isAjaxRequest) {
            $this->controller->renderPartial($this->ajaxView, [
                'model' => $model,
            ]);
        } else {
            $this->controller->render($this->view, [
                'model' => $model,
            ]);
        }
    }
}
