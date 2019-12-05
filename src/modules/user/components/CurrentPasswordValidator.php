<?php

namespace app\modules\user\components;

use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\validators\Validator;

/**
 * DCurrentPassword validates that the old password is correct.
 *
 * /blog/10
 * @version 1.0
 */
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

    public function validateAttribute($object, $attribute): void
    {
        $this->checkDependsOnAttributes($object);

        $value = $object->$attribute;
        if ($this->allowEmpty && $this->isEmpty($value)) {
            return;
        }

        $model = $this->loadModel($object);

        if (!$value) {
            $this->addError($object, $attribute, $this->emptyMessage);
        } elseif (!$model->{$this->validateMethod}($value)) {
            $this->addError($object, $attribute, $this->notValidMessage, ['{value}' => Html::encode($value)]);
        }
    }

    private function checkDependsOnAttributes($object): void
    {
        foreach ($this->dependsOnAttributes as $attr) {
            if (!empty($object->$attr)) {
                $this->allowEmpty = false;
            }
        }
    }

    private function loadModel($object): ActiveRecord
    {
        if (empty($this->idAttribute)) {
            throw new Exception('Attribute idAttribute is not defined');
        }

        if (empty($object->{$this->idAttribute})) {
            throw new Exception('Attribute ' . $this->idAttribute . ' not found');
        }

        if (empty($this->validateMethod)) {
            throw new Exception('Attribute validateMethod is not defined');
        }

        if (empty($this->className)) {
            $this->className = get_class($object);
        }

        $model = ([$this->className, 'findOne'])($object->{$this->idAttribute});

        if ($model === null) {
            throw new Exception('Model not found');
        }

        if (!method_exists($model, $this->validateMethod)) {
            throw new Exception('Method ' . $this->className . '::' . $this->validateMethod . '() not found');
        }

        return $model;
    }
}
