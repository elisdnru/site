<?php
/**
 * DCurrentPassword validates that the old password is correct.
 *
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru/blog/10
 * @version 1.0
 */

class DCurrentPassword extends CValidator
{
    public $className = null;
    public $validateMethod = 'validatePassword';
    public $idAttribute = 'id';
    public $allowEmpty = true;
    public $dependsOnAttributes = array();
    public $emptyMessage = 'Current password required';
    public $notValidMessage = 'Current password is not correct';

    protected function validateAttribute($object,$attribute)
    {
        $this->checkDependsOnAttributes($object);

        $value = $object->$attribute;
        if($this->allowEmpty && $this->isEmpty($value))
            return;

        $model = $this->loadModel($object);

        if (!$value)
            $this->addError($object, $attribute, $this->emptyMessage);
        elseif (!$model->{$this->validateMethod}($value))
            $this->addError($object, $attribute, $this->notValidMessage, array('{value}' => CHtml::encode($value)));
    }

    protected function checkDependsOnAttributes($object)
    {
        foreach ($this->dependsOnAttributes as $attr)
            if (!empty($object->$attr))
                $this->allowEmpty = false;
    }

    protected function loadModel($object)
    {
        if (empty($this->idAttribute))
            throw new CException('Attribute idAttribute is not defined');

        if (empty($object->{$this->idAttribute}))
            throw new CException('Attribute ' . $this->idAttribute . ' not found');

        if (empty($this->validateMethod))
            throw new CException('Attribute validateMethod is not defined');

        if (empty($this->className))
            $this->className = get_class($object);

        $model = CActiveRecord::model($this->className)->findByPk($object->{$this->idAttribute});

        if (is_null($model))
            throw new CException('Model not found');

        if (!method_exists($model, $this->validateMethod))
            throw new CException('Method ' . $this->className . '::' . $this->validateMethod . '() not found');

        return $model;
    }
}