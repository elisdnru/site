<?php
$this->pageTitle='Панель управления';
$this->breadcrumbs=array(
	'Панель управления',
);

$this->admin[] = array('label'=>'Вернуться на сайт', 'url'=>'/index');
$this->info = 'Здесь Вы можете управлять содержимым сайта и сообщениями';

?>
<h1>Панель управления</h1>

<div class="controlPanel">

    <?php
    $notifications = array();
    foreach ($modules as $group){
        foreach ($group as $module){
            if (Yii::app()->moduleManager->active($module->id) && Yii::app()->moduleManager->notifications($module->id)){
                 $notifications = array_merge($notifications, Yii::app()->moduleManager->notifications($module->id));
            }
        }
    }
    ?>
    <fieldset>
        <h2>Уведомления</h2>
        <ul class="adminlist">
            <li>
                <ul>
                    <?php $this->widget('DIconMenu', array('items'=>$notifications, 'iconsPath'=>'/core/images/admin/'));?>
                </ul>
                <div class="clear"></div>
            </li>
        </ul>
    </fieldset>

    <?php foreach ($modules as $group=>$groupModules): ?>

        <?php
        $has = false;
        foreach ($groupModules as $module){
            if (Yii::app()->moduleManager->active($module->id) && Yii::app()->moduleManager->adminMenu($module->id)){
                $has = true;
                break;
            }
        }
        ?>

        <?php if ($has): ?>
        <fieldset>
            <h2><?php echo $group; ?></h2>
            <ul class="adminlist">
                <?php foreach ($groupModules as $module): ?>
                <?php if  (Yii::app()->moduleManager->active($module->id) && Yii::app()->moduleManager->adminMenu($module->id)): ?>
                    <li>
                        <?php if ($module->name != $group): ?><h3><?php echo $module->name; ?></h3><?php endif; ?>
                        <ul>
                            <?php $this->widget('DIconMenu', array('items'=>array_merge(Yii::app()->moduleManager->adminMenu($module->id), Yii::app()->moduleManager->notifications($module->id)), 'iconsPath'=>'/core/images/admin/'));?>
                        </ul>
                        <div class="clear"></div>
                    </li>
                    <?php endif; ?>
                <?php endforeach; ?></ul>
            </ul>
        </fieldset>
        <?php endif; ?>
    <?php endforeach; ?>

</div>