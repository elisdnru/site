<?php
$this->pageTitle='Профиль пользователя ' . $model->username;
$this->breadcrumbs=array(
    'Пользователи' => $this->createUrl('index'),
    $model->username
);

if ($this->is(Access::ROLE_CONTROL))
{
    $this->admin[] = array('label'=>'Пользователи', 'url'=>$this->createUrl('/user/userAdmin/index'));
    $this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('/user/userAdmin/update', array('id'=>$model->id)));

    $this->info = 'Управлять пользователями Вы можете в панели управления';
}
?>


<?php $this->beginWidget('DPortlet', array('title' => 'Профиль пользователя'));?>

<div style="float:left; margin-bottom:10px">
    <img src="<?php echo $model->avatarUrl; ?>" alt="" width="50" />
</div>

<div style="margin-left:60px;">

    <?php if ($model->id == Yii::app()->user->id): ?>
    <p style="float:right">
        <a href="<?php echo $this->createUrl('/users/profile'); ?>">Редактировать</a> |
        <a href="<?php echo $this->createUrl('/user/default/logout'); ?>">Выход</a>
    </p>
    <?php endif; ?>

    <h3>
        <?php if ($model->network): ?>
        <a rel="nofollow" href="<?php echo $model->identity; ?>"><img style="vertical-align: middle" src="<?php echo DSocNetworkHelper::getIcon($model->network); ?>" /></a>
        <?php endif; ?>
        <?php echo CHtml::encode($model->fio); ?>
    </h3>
</div>

<div class="clear"></div>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'tagName'=>'table',
    'itemTemplate'=>"<tr><th style=\"width:150px; text-align:left\">{label}</th><td>{value}</td></tr>\n",
    'htmlOptions'=>array('class'=>'detail-view nomargin'),
    'cssFile'=>false,
    'attributes'=>array_merge(
        array(
            'username',
            array(
                'label'=>'Сайт',
                'type'=>'html',
                'value'=>CHtml::link(CHtml::encode($model->site), $model->site),
                'visible'=>$model->site,
            ),
            array(
                'label'=>'Google+',
                'type'=>'html',
                'value'=>CHtml::link(CHtml::image(DSocNetworkHelper::getIcon('google')), $model->googleplus),
                'visible'=>$model->googleplus,
            ),
        ),

        $model->getAttrDetailView(),

        array(
            array(
                'label'=>'Комментариев',
                'type'=>'html',
                'value'=>$model->comments_count,
                'visible'=>$model->comments_count,
            ),
        )
    ),
));
?>

<?php $this->endWidget();?>

