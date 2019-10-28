<?php

namespace app\components\crud\actions;

class ViewAction extends CrudAction
{
    public $view = 'view';

    public function run(): void
    {
        $model = $this->loadModel();

        $this->clientCallback('beforeView', $model);

        $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}
