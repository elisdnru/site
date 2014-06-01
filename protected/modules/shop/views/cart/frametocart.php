<?php if ($model->models): ?>
	<h1>Выберите модель</h1>
<?php endif; ?>

<div class="form nomargin">

	<?php if ($model->models): ?>
    <div class="shop_models">
        <ul>
            <li><div class="any"><p>Любую</p></div><?php echo CHtml::radioButton('model', true, array('value'=>'')); ?></li>
            <?php foreach ($model->models as $subModel): ?>
            <li><?php echo CHtml::image($subModel->getImageThumbUrl(150, 150)); ?><?php echo CHtml::radioButton('model', false, array('value'=>$subModel->title)); ?></li>
            <?php endforeach; ?>

        </ul>
        <div class="clear"></div>
    </div>
	<?php endif; ?>

    <div class="row" style="float:left; margin:2px 10px 0 0">
        <p>Количество: <input type="number" name="count_<?php echo md5(microtime()); ?>" value="1" style="width:40px" id="productsCount" /></p>
    </div>
    <div class="row buttons nomargin">
        <p><?php echo CHtml::button('В корзину', array('id'=>'addAndComplete', 'style'=>'width:100px')); ?></p>
    </div>
</div>

<script type="text/javascript">
/* <![CDATA[ */
(function($){

    $('.shop_models li').click(function(){
        $('input[name="model"]').attr('checked', false);
        $(this).find('input').attr('checked', true);
    });

    function addToCart(id, model, cnt, complete){

        if (!parseInt(id)) return;
        if (!parseInt(cnt)) cnt = 1;

        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/shop/cart/add'); ?>',
            data:{
                'ToCart[id]': parseInt(id),
                'ToCart[data][model]': model,
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
            $('input[name="model"]:checked').val(),
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