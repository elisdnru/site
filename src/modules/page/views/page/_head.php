<?php

declare(strict_types=1);

use app\modules\page\models\Page;
use app\modules\user\models\Access;
use yii\web\View;

/**
 * @var View $this
 * @var Page $page
 */
$this->title = $page->meta_title ?: $page->title;

$this->registerMetaTag(['name' => 'description', 'content' => $page->meta_description]);

$this->params['breadcrumbs'] = $page->alias !== 'index' ? $page->getBreadcrumbs() : [];

$this->registerMetaTag(['name' => 'robots', 'content' => $page->robots]);

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('page')) {
        $this->params['admin'][] = ['label' => 'Редактировать', 'url' => ['/page/admin/page/update', 'id' => $page->id]];
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
        $this->params['admin'][] = ['label' => 'Подстраницы', 'url' => ['/page/admin/page/index', 'Page[parent_id]' => $page->id]];
    }
}
