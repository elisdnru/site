<?php
/* @var $this DController */
/* @var $model Slide */

$this->pageTitle='Просмотр слайда';
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Слайды'=>array('index'),
    'Просмотр',
);

$this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('update', array('id'=>$model->id)));
$this->admin[] = array('label'=>'Слайды', 'url'=>$this->createUrl('index'));

$this->info = 'Слайды';
?>

<?php
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
$cs->registerScriptFile('jquery.easing.js');
$url = CHtml::asset(Yii::getPathOfAlias('slideshow.assets'));
$cs->registerScriptFile($url . '/easySlider.js', CClientScript::POS_HEAD);
?>

<?php
$id = uniqid('slider_');
?>

<div id="<?php echo $id; ?>" class="slider">
    <ul>
        <li style="background-image: url('<?php echo $model->imageUrl; ?>');">
            <div class="content">
                <p class="title"><a href="<?php echo CHtml::encode($model->url); ?>"><span><?php echo implode('</span><br /><span>', explode('<br />', nl2br(CHtml::encode($model->title)))) ; ?></span></a></p>
                <p class="text"><span><?php echo nl2br(CHtml::encode($model->text)); ?></span></p>
            </div>
        </li>
    </ul>
</div>

<script type="text/javascript">
    jQuery(function() {
        jQuery('#<?php echo $id; ?>').easySlider({
            auto: true,
            pause: 5000,
            continuous: true,
            controlsShow: false
        });
    });
</script>