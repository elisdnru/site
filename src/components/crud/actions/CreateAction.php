<?php

namespace app\components\crud\actions;

class CreateAction extends CrudAction
{
    /**
     * @var string view file for rendering
     */
    public $view = 'create';
    /**
     * @var string success message
     */
    public $success = 'Added successfully';

    public function run()
    {
        $model = $this->createModel();

        $formName = (new \ReflectionObject($model))->getShortName();

        if (isset($_POST[$formName])) {
            $model->attributes = $_POST[$formName];

            $this->clientCallback('beforeCreate', $model);
            $this->clientCallback('performAjaxValidation', $model);

            if ($model->save()) {
                $this->success($this->success);
                $this->redirectToView($model);
            }
        }

        $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}