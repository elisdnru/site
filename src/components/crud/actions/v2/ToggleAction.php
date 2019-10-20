<?php

namespace app\components\crud\actions\v2;

use app\components\crud\Messages;
use Yii;
use yii\web\HttpException;

class ToggleAction extends CrudAction
{
    /**
     * @var string success message
     */
    public $success = 'Changed successfully';
    /**
     * @var string error message
     */
    public $error = 'Error';
    /**
     * @var mixed toggable attributes
     */
    public $attributes = ['public'];

    public function run(): void
    {
        $this->checkIsPostRequest();

        $attribute = $this->getAttribute();

        $model = $this->loadModel();

        $this->clientCallback('beforeToggle', $model);

        $model->$attribute = $model->$attribute ? '0' : '1';

        if ($model->save()) {
            $this->success($this->success);
        } else {
            $this->error($this->error);
        }

        $this->redirectToView($model);
    }

    protected function getAttribute(): string
    {
        if (empty($this->attributes)) {
            throw new HttpException(400, Yii::t(Messages::class . '.crud', 'ToggleAction::attributes is empty'));
        }

        $attribute = Yii::app()->request->getParam('attribute');

        if (!in_array($attribute, $this->attributes, true)) {
            throw new HttpException(400, Yii::t(Messages::class . '.crud', 'Missing attribute {attribute}', ['{attribute}' => $attribute]));
        }

        return $attribute;
    }
}
