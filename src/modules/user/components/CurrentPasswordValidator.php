<?php

namespace app\modules\user\components;

use yii\base\Exception;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\validators\Validator;

class CurrentPasswordValidator extends Validator
{
    public string $className = '';
    public string $validateMethod = 'validatePassword';
    public string $idAttribute = 'id';
    public string $emptyMessage = 'Current password required';
    public string $notValidMessage = 'Current password is not correct';

    public function validateAttribute($model, $attribute): void
    {
        /** @var string $value */
        $value = $model->$attribute;
        $record = $this->loadModel($model);

        if (!$value) {
            $this->addError($model, $attribute, $this->emptyMessage);
        } elseif (!$record->{$this->validateMethod}($value)) {
            $this->addError($model, $attribute, $this->notValidMessage, ['{value}' => Html::encode($value)]);
        }
    }

    private function loadModel(Model $model): ActiveRecord
    {
        if (empty($this->idAttribute)) {
            throw new Exception('Attribute idAttribute is not defined');
        }

        if (empty($model->{$this->idAttribute})) {
            throw new Exception('Attribute ' . $this->idAttribute . ' not found');
        }

        if (empty($this->validateMethod)) {
            throw new Exception('Attribute validateMethod is not defined');
        }

        if (empty($this->className)) {
            $this->className = get_class($model);
        }

        /** @var ?ActiveRecord $record */
        $record = ([$this->className, 'findOne'])($model->{$this->idAttribute});

        if ($record === null) {
            throw new Exception('Model not found');
        }

        if (!method_exists($record, $this->validateMethod)) {
            throw new Exception('Method ' . $this->className . '::' . $this->validateMethod . '() not found');
        }

        return $record;
    }
}
