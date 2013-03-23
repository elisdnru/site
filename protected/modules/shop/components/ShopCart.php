<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */
class ShopCart extends CApplicationComponent
{
    /**
     * @var ShopCartItem[]
     */
    protected $cart = array();

    protected $session_key = 'cart';

    public function init(){
         $this->load();
    }

    public function add(ShopCartItem $item)
    {
        $this->load();
        $id = $item->hash;

        if (isset($this->cart[$id]))
            $this->cart[$id]->count += (int)$item->count;
        else
            $this->cart[$id] = $item;

        $this->save();
    }

    public function del($id)
    {
        $this->load();

        if (isset($this->cart[$id]))
        {
            $this->cart[$id]->count += -1;
            if ($this->cart[$id]->count < 1)
                unset($this->cart[$id]);
        }

        $this->save();
    }

    public function set($id, $count)
    {
        $this->load();

        $this->cart[$id]->count = (int)$count;

        if ($this->cart[$id]->count < 1)
            unset($this->cart[$id]);

        $this->save();
    }

    public function get($id)
    {
        $this->load();
        return isset($this->cart[$id]) ? $this->cart[$id] : 0;
    }

    public function remove($id)
    {
        $this->load();
        unset($this->cart[$id]);
        $this->save();
    }

    public function clear()
    {
        $this->load();
        $this->cart = array();
        $this->save();
    }

    public function getAssoc()
    {
        $this->load();
        return $this->cart;
    }

    protected function save()
    {
        $stage = array();
        foreach ($this->cart as $id=>$item)
        {
            $stage[$id] = $item->serialize();
        }

        Yii::app()->session[$this->session_key] = $stage;
    }

    protected function load()
    {
        $this->cart = array();

        if (!empty(Yii::app()->session[$this->session_key]))
        {
            $data = Yii::app()->session[$this->session_key];
            foreach ($data as $id=>$hash)
            {
                $item = new ShopCartItem();
                $item->unserialize($hash);
                $this->cart[$id] = $item;
            }
        }
    }
}