<?php

class DCreateAction extends DCrudAction
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

        $modelName = get_class($model);

        if (isset($_POST[$modelName])) {
            $model->attributes = $_POST[$modelName];

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
