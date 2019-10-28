<?php

namespace app\components\crud\actions;

use ReflectionObject;
use Yii;

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

        if ($post = Yii::$app->request->post($formName)) {
            $model->attributes = $post;

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
