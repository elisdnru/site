<?php

DUrlRulesHelper::import('shop');

class ShopStarRating extends CStarRating
{
    public $maxRating = 5;
    public $product;
    public $resetText='';

    public function init()
    {
        $this->value = round($this->product->rating);

        $this->callback = '
            function(){
                $.ajax({
                    type: "POST",
                    url: "' . Yii::app()->createUrl('/shop/product/rating', array('id'=>$this->product->id)) . '",
                    data: {
                        rate: $(this).val(),
                        YII_CSRF_TOKEN: getCSRFToken(),
                    },
                    success: function(msg){
                        alert("Ваш голос засчитан")
                    },
                    error: function(XHR){
                        alert("Error " + XHR.responseText)
                    }
                });
            }
        ';

        parent::init();
    }
}
