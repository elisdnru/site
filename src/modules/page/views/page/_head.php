<?php
/** @var $page Page */

use app\modules\page\models\Page;
use app\modules\user\models\Access;

$this->title = $page->pagetitle ?: $page->title;

$this->registerMetaTag(['name' => 'description', 'content' => $page->description]);

$this->params['breadcrumbs'] = $page->alias !== 'index' ? $page->breadcrumbs : [];

$this->registerMetaTag(['name' => 'robots', 'content' => $page->robots]);

if (Yii::app()->user->checkAccess(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('page')) {
        $this->params['admin'][] = ['label' => 'Редактировать', 'url' => ['/page/admin/page/update', 'id' => $page->id]];
        $this->params['admin'][] = ['label' => 'Cтраницы', 'url' => ['/page/admin/page/index']];
        $this->params['admin'][] = ['label' => 'Подстраницы', 'url' => ['/page/admin/page/index', 'Page[parent_id]' => $page->id]];
    }
}
