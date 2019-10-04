<div class="search_form">
    <?php use app\components\module\UrlRulesHelper;

    UrlRulesHelper::import('search'); ?>
    <?php echo CHtml::beginForm(Yii::app()->createUrl('/search/default/index'), 'get'); ?>
    <div class="search_word">
        <?php echo CHtml::textField('q', $form->q, ['placeholder' => 'Поиск']); ?>
    </div>
    <div class="search_button">
        <?php echo CHtml::submitButton(''); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>
