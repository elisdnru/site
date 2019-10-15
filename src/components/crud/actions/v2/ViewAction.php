<?php

namespace app\components\crud\actions\v2;

use yii\helpers\Json;

class ViewAction extends CrudAction
{
    public $view = 'view';
    public $json = false;

    public function run(): void
    {
        $model = $this->loadModel();

        $this->clientCallback('beforeView', $model);

        if ($this->json && isset($_GET['json'])) {
            echo Json::encode($model);
        } else {
            $this->controller->render($this->view, [
                'model' => $model,
            ]);
        }
    }
}
