<div class="form" style="padding:30px 0 0 0">
    <p class="center">Количество: <input type="number" name="count_<?php echo md5(microtime()); ?>" value="1" style="width:40px" id="productsCount" /></p>

    <div class="row buttons center">
        <p><?php echo CHtml::button('В корзину', array('id'=>'addAndComplete', 'style'=>'width:140px')); ?></p>
    </div>
</div>

<script type="text/javascript">
/* <![CDATA[ */
(function($){

    function addToCart(id, cnt, complete){

        if (!parseInt(id)) return;
        if (!parseInt(cnt)) cnt = 1;

        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/shop/cart/add'); ?>/' + parseInt(id),
            data:{
                'ToCart[count]': parseInt(cnt),
                'YII_CSRF_TOKEN': getCSRFToken()
            },
            success: function(data){
                parent.updateCart(getCSRFToken());
                complete();
            },
            error:function(XHR) {
                alert(XHR.responseText);
            }
        });
    }

    $('#addAndComplete').click(function(){
        addToCart(
            <?php echo (int)$model->id; ?>,
            $('#productsCount').val(),
            function(){
                parent.showCartProcess();
                parent.$.colorbox.close();
            }
        );
        return false;
    });

})(jQuery);

/* ]]> */
</script>