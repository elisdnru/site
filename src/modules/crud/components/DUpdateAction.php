<?php


class DUpdateAction extends DCrudAction
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

        $modelName = get_class($model);

        if (isset($_POST[$modelName])) {
            $model->attributes = $_POST[$modelName];

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
