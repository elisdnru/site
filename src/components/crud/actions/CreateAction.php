<?php

namespace app\components\crud\actions;

use ReflectionObject;

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

        $formName = (new ReflectionObject($model))->getShortName();

        if (isset($_POST[$formName])) {
            $model->attributes = $_POST[$formName];

            $this->clientCallback('beforeCreate', $model);

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
