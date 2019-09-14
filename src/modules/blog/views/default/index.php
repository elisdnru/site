<?php
/* @var $this DController */

use app\modules\main\components\DController;
use app\modules\main\components\helpers\DNumberHelper;
use app\modules\page\models\Page;
use app\modules\user\models\Access;

/* @var $page Page */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = $page->pagetitle . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = $page->description . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->keywords = $page->keywords;

$this->breadcrumbs = [
    'Блог',
];

if ($this->is(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/postAdmin')];
    }
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Добавить запись', 'url' => $this->createUrl('/blog/postAdmin/create')];
    }
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/blog/categoryAdmin')];
    }
    if ($this->moduleAllowed('blog') && $page->id) {
        $this->admin[] = ['label' => 'Редактировать страницу', 'url' => $this->createUrl('/page/pageAdmin/update', ['id' => $page->id])];
    }
    if ($this->moduleAllowed('blog') && $this->moduleAllowed('comment')) {
        $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications($this->module->id));
    }

    $this->info = 'Здесь собраны записи из всех разделов';
}
?>

<h1><?php echo CHtml::encode($page->title); ?></h1>

<?php if (Yii::app()->request->getParam('page', 1) > 1) :
?>
<noindex><?php
    endif; ?>
    <?php echo $this->decodeWidgets(trim($page->text_purified)); ?>
    <?php if (Yii::app()->request->getParam('page', 1) > 1) :
    ?></noindex><?php
endif; ?>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
