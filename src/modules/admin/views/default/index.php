<?php
use app\components\module\Module;
use app\widgets\IconMenu;

/** @var $modules Module[] */

$this->title = 'Панель управления';
$this->params['breadcrumbs'] = [
    'Панель управления',
];

$this->params['admin'][] = ['label' => 'Вернуться на сайт', 'url' => '/'];

?>
<h1>Панель управления</h1>

<div class="controlPanel">

    <?php
    $notifications = [];
    foreach ($modules as $group) {
        foreach ($group as $module) {
            if (Yii::$app->moduleAdminNotifications->notifications($module->id)) {
                $notifications = array_merge($notifications, Yii::$app->moduleAdminNotifications->notifications($module->id));
            }
        }
    }
    ?>
    <fieldset>
        <h2>Уведомления</h2>
        <ul class="adminlist">
            <li>
                <ul>
                    <?= IconMenu::widget(['items' => $notifications, 'iconsPath' => '/images/admin/']) ?>
                </ul>
                <div class="clear"></div>
            </li>
        </ul>
    </fieldset>

    <?php foreach ($modules as $group => $groupModules) : ?>
        <?php
        $has = false;
        foreach ($groupModules as $module) {
            if (Yii::$app->moduleAdminMenu->menu($module->id)) {
                $has = true;
                break;
            }
        }
        ?>

        <?php if ($has) : ?>
            <fieldset>
                <h2><?= $group ?></h2>
                <ul class="adminlist">
                    <?php foreach ($groupModules as $module) : ?>
                        <?php if (Yii::$app->moduleAdminMenu->menu($module->id)) : ?>
                            <li>
                                <?php if ($module->name !== $group) : ?>
                                    <h3><?= $module->name ?></h3><?php
                                endif; ?>
                                <ul>
                                    <?= IconMenu::widget([
                                        'items' => array_merge(Yii::$app->moduleAdminMenu->menu($module->id), Yii::$app->moduleAdminNotifications->notifications($module->id)),
                                        'iconsPath' => '/images/admin/'
                                    ]) ?>
                                </ul>
                                <div class="clear"></div>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </fieldset>
        <?php endif; ?>
    <?php endforeach; ?>

    <fieldset>
        <h2>Дополнительно</h2>
        <ul class="adminlist">
            <li>
                <ul>
                    <?= IconMenu::widget(['items' => [
                        ['label' => 'Очистить кэш', 'url' => ['/admin/cache/clear'], 'icon' => 'clear.png'],
                    ], 'iconsPath' => '/images/admin/']) ?>
                </ul>
                <div class="clear"></div>
            </li>
        </ul>
    </fieldset>

</div>
