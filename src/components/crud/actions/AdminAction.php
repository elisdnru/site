<?php

namespace app\components\crud\actions;

class AdminAction extends CrudAction
{
    /**
     * @var string view file for rendering
     */
    public $view = 'admin';
    /**
     * @var string search scenarion name
     */
    public $scenario = 'search';

    public function run(): void
    {
        /** @var \CActiveRecord $model */
        $model = $this->createModel();

        $formName = (new \ReflectionObject($model))->getShortName();

        $modelName = get_class($this->createModel());

        $model = new $modelName($this->scenario);

        $model->unsetAttributes();
        if (isset($_GET[$formName])) {
            $model->attributes = $_GET[$formName];
        }

        $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}
