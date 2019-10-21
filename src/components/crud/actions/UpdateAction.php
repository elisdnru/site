<?php

namespace app\components\crud\actions;

use ReflectionObject;

class UpdateAction extends CrudAction
{
    /**
     * @var string view file for rendering
     */
    public $view = 'update';
    /**
     * @var string success message
     */
    public $success = 'Saved successfully';
    /**
     * @var string error message
     */
    public $error = 'Error';

    public function run(): void
    {
        $model = $this->loadModel();

        $formName = (new ReflectionObject($model))->getShortName();

        if (isset($_POST[$formName])) {
            $model->attributes = $_POST[$formName];

            $this->clientCallback('beforeUpdate', $model);

            if ($model->save()) {
                $this->success($this->success);
                $this->redirectToView($model);
            } else {
                $this->error($this->error);
            }
        }

        $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}
