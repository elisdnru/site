<?php

namespace app\modules\crud\components;

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

    public function run()
    {
        $model = $this->loadModel();

        $formName = (new \ReflectionObject($model))->getShortName();

        if (isset($_POST[$formName])) {
            $model->attributes = $_POST[$formName];

            $this->clientCallback('beforeUpdate', $model);
            $this->clientCallback('performAjaxValidation', $model);

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