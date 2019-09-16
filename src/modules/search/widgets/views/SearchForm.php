<div class="search_form form">
    <?php use app\components\module\DUrlRulesHelper;

    DUrlRulesHelper::import('search'); ?>
    <?php echo CHtml::beginForm(Yii::app()->createUrl('/search/default/index'), 'get'); ?>
    <div class="row search_word">
        <?php echo CHtml::textField('q', $form->q, ['placeholder' => 'Поиск']); ?>
    </div>
    <div class="row buttons search_button">
        <?php echo CHtml::submitButton(''); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>
