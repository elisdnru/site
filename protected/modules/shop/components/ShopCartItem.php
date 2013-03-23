<?php

Yii::import('application.modules.shop.models.ShopProduct');

class ShopCartItem extends CFormModel
{
    public $id;
    public $data;
    public $count;

    private $_model;

    public function rules()
    {
        return array(
            array('id, count', 'required'),
            array('id', 'required'),
            array('id', 'CExistValidator', 'className' => 'ShopProduct', 'attributeName' => 'id'),
            array('data', 'safe'),
        );
    }

    protected  function beforeValidate()
    {
        if (parent::beforeValidate())
        {
            if ($this->count > $this->getModel()->count)
                $this->count = $this->getModel()->count;

            if (!$this->count)
                $this->count = 1;

            ksort($this->data);

            return true;
        }
        else
            return false;
    }

    public function getHash()
    {
        return md5(serialize(array(
            $this->id,
            $this->data,
        )));
    }

    public function getModel()
    {
        if ($this->_model === null)
            $this->_model = ShopProduct::model()->findByPk($this->id);
        return $this->_model;
    }

    public function serialize()
    {
        return serialize(array(
            'id'=>$this->id,
            'data'=>$this->data,
            'count'=>$this->count,
        ));
    }

    public function unserialize($hash)
    {
        $data = unserialize($hash);
        $this->id = $data['id'];
        $this->data = $data['data'];
        $this->count = $data['count'];
    }
}
