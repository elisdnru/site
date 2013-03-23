<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 * @version 1.0
 */

class DAttributeBehavior extends CActiveRecordBehavior
{
    protected $attributeNames;
    protected $attributeLabels;
    protected $attributeValues;

	public function canGetProperty($name)
    {
        return $this->validProperty($name) || parent::canGetProperty($name);
    }

    public function canSetProperty($name)
    {
        return $this->validProperty($name) || parent::canSetProperty($name);
    }

    public function __isset($name)
    {
        return $this->validProperty($name) || parent::__isset($name);
    }

    public function __get($name)
    {
        if ($this->validProperty($name))
        {
            if (!isset($this->attributeValues[$name]))
                $this->attributeValues[$name] = '';

            return $this->attributeValues[$name];
        }
        else
            return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if ($this->validProperty($name))
            $this->attributeValues[$name] = $value;
        else
            parent::__set($name, $value);
    }

    public function getAttrDetailView($autoVisible=true)
    {
        $this->initValues();

        $items = array();
        foreach ($this->attributeValues as $name=>$value)
        {
             $items[] = array(
                 'label'=>$this->attributeLabels[$name],
                 'value'=>$value,
                 'visible'=>$autoVisible ? $value : 1,
             );
        }

        return $items;
    }

    public function afterSave($event)
    {
        $this->saveAttributesValues();
    }

    protected function validProperty($name)
    {
        $this->initValues();

        return in_array($name, $this->attributeNames) && !in_array($name, $this->getOwner()->attributeNames());
    }

    protected function initValues()
    {
        $this->loadAttributesNames();
        $this->loadAttributesValues();
    }

    protected function loadAttributesNames()
    {
        if ($this->attributeNames === null) {
            $this->attributeNames = array();
            $this->attributeLabels = array();

            $attrs = UserAttribute::model()->cache(3600)->findAll(array(
                'condition' => 'class = :class',
                'params' => array(':class' => get_class($this->getOwner())),
                'order' => 'sort',
            ));

            foreach ($attrs as $attr) {
                $this->attributeNames[] = $attr->name;
                $this->attributeLabels[$attr->name] = $attr->label;
            }
        }
    }

    protected function loadAttributesValues()
    {
        if ($this->attributeValues === null)
        {
            $this->attributeValues = array();

            $attrs = UserAttributeValue::model()->findAllByAttributes(array('owner_id' => $this->getOwner()->getPrimaryKey()));

            foreach ($attrs as $attr) {
                if ($attr->attribute)
                    $this->attributeValues[$attr->attribute->name] = $attr->value;
            }
        }
    }

    protected function saveAttributesValues()
    {
        if ($this->attributeValues !== null)
        {
            foreach ($this->attributeValues as $name=>$value)
            {
                $model = $this->loadOrCreateValueModel($name, $this->getOwner()->getPrimaryKey());
                $model->value = $value;
                $model->save();
            }
        }
    }

    protected function loadOrCreateValueModel($name, $ownerId)
    {
        $attribute = UserAttribute::model()->findByAttributes(array(
            'name' => $name,
        ));

        $model = UserAttributeValue::model()->findByAttributes(array(
            'owner_id' => $ownerId,
            'attribute_id' => $attribute->id,
        ));

        if ($model === null)
        {
            $model = new UserAttributeValue();
            $model->owner_id = $ownerId;
            $model->attribute_id = $attribute->id;
        }

        return $model;
    }
}