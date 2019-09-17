<?php

namespace app\modules\crud\components;

use CJSON;

class ViewAction extends CrudAction
{
    public $view = 'view';
    public $json = false;

    public function run()
    {
        $model = $this->loadModel();

        $this->clientCallback('beforeView', $model);

        if ($this->json && isset($_GET['json'])) {
            echo CJSON::encode($model);
        } else {
            $this->controller->render($this->view, [
                'model' => $model,
            ]);
        }
    }
}
