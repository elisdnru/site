<?php declare(strict_types=1);

use app\components\module\admin\AdminDashboardItem;
use app\widgets\IconMenu;
use yii\base\Module;
use yii\web\View;

/**
 * @var View $this
 * @var Module[][] $groups
 * @psalm-var array<string, Module[]> $groups
 */
$this->title = 'Панель управления';
$this->params['breadcrumbs'] = [
    'Панель управления',
];

$this->params['admin'][] = ['label' => 'Вернуться на сайт', 'url' => '/'];

?>
<h1>Панель управления</h1>

<div class="control-panel">

    <?php
    $notifications = [];
    foreach ($groups as $modules) {
        foreach ($modules as $module) {
            foreach (Yii::$app->moduleAdminNotifications->notifications($module->id) as $notification) {
                $notifications[] = $notification;
            }
        }
    }
    ?>
    <fieldset>
        <h2>Уведомления</h2>
        <ul class="adminlist">
            <li>
                <ul>
                    <?= IconMenu::widget(['items' => $notifications, 'iconsPath' => '/images/admin/']); ?>
                </ul>
                <div class="clear"></div>
            </li>
        </ul>
    </fieldset>

    <?php foreach ($groups as $group => $modules) : ?>
        <?php
        $has = false;
        foreach ($modules as $module) {
            if (Yii::$app->moduleAdminMenu->menu($module->id)) {
                $has = true;
                break;
            }
        }
        ?>

        <?php if ($has) : ?>
            <fieldset>
                <h2><?= $group; ?></h2>
                <ul class="adminlist">
                    <?php
                    /**
                     * @var AdminDashboardItem&Module $module
                     */
                    foreach ($modules as $module) : ?>
                        <?php if (Yii::$app->moduleAdminMenu->menu($module->id)) : ?>
                            <li>
                                <?php if ($module->adminName() !== $group) : ?>
                                    <h3><?= $module->adminName(); ?></h3>
                                <?php endif; ?>
                                <ul>
                                    <?= IconMenu::widget([
                                        'items' => array_merge(Yii::$app->moduleAdminMenu->menu($module->id), Yii::$app->moduleAdminNotifications->notifications($module->id)),
                                        'iconsPath' => '/images/admin/',
                                    ]); ?>
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
                    ], 'iconsPath' => '/images/admin/']); ?>
                </ul>
                <div class="clear"></div>
            </li>
        </ul>
    </fieldset>

</div>
