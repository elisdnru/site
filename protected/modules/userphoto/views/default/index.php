<?php
/* @var $this DController */

$username = Yii::app()->request->getQuery('username');

$this->pageTitle = 'Фоторграфии пользователя ' . $username;
$this->description = '';
$this->keywords = '';

$this->breadcrumbs=array(
    $username => $this->createUrl('/user/users/show', array('username'=>$username)),
    'Фоторграфии',
);


if ($this->is(Access::ROLE_CONTROL))
{
    if ($this->moduleAllowed('userphoto')) $this->admin[] = array('label'=>'Фотографии', 'url'=>$this->createUrl('/userphoto/photoAdmin'));
    if ($this->moduleAllowed('userphoto') && Yii::app()->moduleManager->active('comment') && $this->moduleAllowed('comment')) $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications($this->module->id));

    $this->info = 'Фоторграфии пользователя';
}
?>

<h1>Фоторграфии пользователя <?php echo CHtml::encode($username); ?></h1>

<?php if (Yii::app()->user->id): ?>
    <p>
        <a href="<?php echo $this->createUrl('/userphoto/photo/create'); ?>">Загрузить фотографии в свой альбом</a>
    </p>
<?php endif; ?>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>