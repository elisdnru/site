<?php

class ShopModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.shop.components.*',
            'application.modules.shop.models.*',
        ));
    }

    public function getGroup()
    {
        return 'Магазин';
    }

    public function getName()
    {
        return 'Магазин';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Типы товара', 'url'=>array('/shop/typeAdmin/index'), 'icon'=>'foldericon.jpg'),
            array('label'=>'Категории', 'url'=>array('/shop/categoryAdmin/index'), 'icon'=>'foldericon.jpg'),
            array('label'=>'Атрибуты', 'url'=>array('/shop/attributeAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Производители', 'url'=>array('/shop/brandAdmin/index'), 'icon'=>'foldericon.jpg'),
            array('label'=>'Способы доставки', 'url'=>array('/shop/posttypeAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Размеры', 'url'=>array('/shop/sizeAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Цвета', 'url'=>array('/shop/colorAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Товары', 'url'=>array('/shop/productAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Модели', 'url'=>array('/shop/modelAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Добавить товар', 'url'=>array('/shop/productAdmin/create'), 'icon'=>'add.png'),
        );
    }

    public static function notifications()
    {
        Yii::import('application.modules.shop.models.ShopOrder');

        $orders = ShopOrder::model()->count('apply=0');

        return array(
            array('label'=>'Заказы' . ($orders ?  ' (' . $orders . ')' : ''), 'url'=>array('/shop/orderAdmin/index'), 'icon'=>'message.png'),
        );
    }

    public static function rules()
    {
        return array(
            'shop/product/rating/<id:\d+>'=>'shop/product/rating',
            'shop/<controller:orders>/<action:\w+>/<id:\d+>'=>'shop/<controller>/<action>',
            'shop/<controller:orders>'=>'shop/<controller>/index',
            'shop/<controller:orders>/<action:\w+>'=>'shop/<controller>/<action>',
            'shop/orders'=>'shop/orders/index',

            'shop/<action:sale|search>'=>'shop/default/<action>',
            'shop/cart/<action:\w+>/<id:.+>'=>'shop/cart/<action>',
            'shop/cart/<action:\w+>'=>'shop/cart/<action>',
            'shop/cart'=>'shop/cart/index',
            'shop/order'=>'shop/order/index',

            'shop/brand/<brand:[\w_-]+>/<type:[\w_-]+>/<category:.+>/page-<page:\d+>'=>'shop/default/brand',
            'shop/brand/<brand:[\w_-]+>/<type:[\w_-]+>/<category:.+>'=>'shop/default/brand',
            'shop/brand/<brand:[\w_-]+>/<type:[\w_-]+>'=>'shop/default/brand',
            'shop/brand/<brand:[\w_-]+>'=>'shop/default/brand',

            'shop/<type:[\w_-]+>/<category:[\w_\/-]+>/<id:[\d]+>'=>'shop/product/show',
            'shop/<type:[\w_-]+>/<category:[\w_\/-]+>/page-<page:\d+>'=>'shop/default/category',
            'shop/<type:[\w_-]+>/<category:[\w_\/-]+>'=>'shop/default/category',
            'shop/<type:[\w_-]+>'=>'shop/default/type',
            'shop'=>'shop/default/index',

            'payment/pay/<id:[\d]+>'=>'payment/pay',
            'payment/success'=>'payment/success',
            'payment/fail'=>'payment/fail',
        );
    }

    public static function registerScripts()
    {
        Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/modules/shop.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/modules/shop.js', CClientScript::POS_END);
    }

    public function install()
    {
        Yii::app()->config->add(array(
            array(
                'param'=>'SHOP.PRODUCTS_PER_PAGE',
                'label'=>'Продуктов на странице',
                'value'=>'10',
                'type'=>'string',
                'default'=>'10',
            ),
            array(
                'param'=>'SHOP.ORDER_AGREEMENT',
                'label'=>'Соглашение покупателя',
                'value'=>'',
                'type'=>'text',
                'default'=>'Соглашение',
            ),
            array(
                'param'=>'SHOP.GROUP_BY_TITLE',
                'label'=>'Группировать по наименованию',
                'value'=>'0',
                'type'=>'checkbox',
                'default'=>'0',
            ),
        ));

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete(array(
            'SHOP.PRODUCTS_PER_PAGE',
            'SHOP.ORDER_AGREEMENT',
        ));

        return parent::uninstall();
    }
}
