<?php

namespace app\components\crud\actions\v2;

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

    public function run(): void
    {
        $model = $this->createModel();

        if ($model->load($_POST)) {
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
