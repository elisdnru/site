<?php
/** @var $page Page */

use app\modules\page\models\Page;
use app\modules\user\models\Access;

$this->pageTitle = $page->pagetitle ?: $page->title;
$this->description = $page->description;
$this->keywords = $page->keywords;

$this->breadcrumbs = $page->alias !== 'index' ? $page->breadcrumbs : [];

Yii::app()->clientScript->registerMetaTag($page->robots, 'robots');

if ($this->is(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('page')) {
        $this->admin[] = ['label' => 'Редактировать', 'url' => $this->createUrl('/page/pageAdmin/update', ['id' => $page->id])];
    }
    if ($this->moduleAllowed('page')) {
        $this->admin[] = ['label' => 'Cтраницы', 'url' => $this->createUrl('/page/pageAdmin/index')];
    }
    if ($this->moduleAllowed('page')) {
        $this->admin[] = ['label' => 'Подстраницы', 'url' => $this->createUrl('/page/pageAdmin/index', ['Page[parent_id]' => $page->id])];
    }
}
?>

