<?php

namespace app\modules\user\components;

use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\validators\Validator;

class CurrentPasswordValidator extends Validator
{
    public $className;
    public $validateMethod = 'validatePassword';
    public $idAttribute = 'id';
    public $allowEmpty = true;
    public $skipOnEmpty = false;
    public $dependsOnAttributes = [];
    public $emptyMessage = 'Current password required';
    public $notValidMessage = 'Current password is not correct';

    public function validateAttribute($model, $attribute): void
    {
        $this->checkDependsOnAttributes($model);

        $value = $model->$attribute;
        if ($this->allowEmpty && $this->isEmpty($value)) {
            return;
        }

        $record = $this->loadModel($model);

        if (!$value) {
            $this->addError($model, $attribute, $this->emptyMessage);
        } elseif (!$record->{$this->validateMethod}($value)) {
            $this->addError($model, $attribute, $this->notValidMessage, ['{value}' => Html::encode($value)]);
        }
    }

    private function checkDependsOnAttributes($model): void
    {
        foreach ($this->dependsOnAttributes as $attr) {
            if (!empty($model->$attr)) {
                $this->allowEmpty = false;
            }
        }
    }

    private function loadModel($model): ActiveRecord
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
