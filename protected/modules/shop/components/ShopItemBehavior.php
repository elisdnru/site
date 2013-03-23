<?php

class ShopItemBehavior extends CActiveRecordBehavior
{
    private $_id;
    private $_cartAttributes;
    private $_count;

    public function getCartId()
    {
        if ($this->_id === null)
            $this->_id = $this->getOwner()->getPrimaryKey();
        return $this->_id;
    }

    public function getCartPrice()
    {
        return $this->getOwner()->price;
    }

    public function getCartAttributes()
    {
        return $this->_cartAttributes;
    }

    public function setCartAttributes($value)
    {
        $this->_cartAttributes = $value;
    }

    public function getCartCount()
    {
        return $this->_count;
    }

    public function setCartCount($value)
    {
        $value = (int)$value;
        $maxCount = $this->getCartMaxCount();
        $this->_count = $value < $maxCount ? $value : $maxCount;
    }

    public function getCartMaxCount()
    {
        return $this->getOwner()->count;
    }
}
