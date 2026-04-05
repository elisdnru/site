<?php

declare(strict_types=1);

use app\modules\page\models\Page;
use app\modules\user\models\Access;
use Webmozart\Assert\Assert;
use yii\web\Application;
use yii\web\View;

/**
 * @var View $this
 * @var Page $page
 */
$this->title = $page->meta_title ?: $page->title;

$this->registerMetaTag(['name' => 'description', 'content' => $page->meta_description]);

$this->params['breadcrumbs'] = $page->slug !== 'index' ? $page->getBreadcrumbs() : [];

$this->registerMetaTag(['name' => 'robots', 'content' => $page->robots]);

if (Assert::isInstanceOf(Yii::$app, Application::class)->user->can(Access::CONTROL)) {
    if (\app\notNull(Yii::$app)->moduleAdminAccess->isGranted('page')) {
        $this->params['admin'][] = ['label' => 'Редактировать', 'url' => ['/page/admin/page/update', 'id' => $page->id]];
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
        $this->params['admin'][] = ['label' => 'Подстраницы', 'url' => ['/page/admin/page/index', 'Page[parent_id]' => $page->id]];
    }
}
