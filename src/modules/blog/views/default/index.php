<?php
/** @var $this Controller */

use app\components\Controller;
use app\components\helpers\NumberHelper;
use app\modules\page\models\Page;
use app\modules\user\models\Access;

/** @var $page Page */
/** @var $dataProvider CActiveDataProvider */

$this->layout = '/layouts/index';

$this->title = $page->pagetitle . NumberHelper::pageString($dataProvider->getPagination()->pageVar);

Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $page->description . NumberHelper::pageString($dataProvider->getPagination()->pageVar)
]);

$this->params['breadcrumbs'] = [
    'Блог',
];

if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
    if (Yii::app()->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post')];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => $this->createUrl('/blog/admin/post/create')];
        $this->params['admin'][] = ['label' => 'Категории', 'url' => $this->createUrl('/blog/admin/category')];
        if ($page->id) {
            $this->params['admin'][] = ['label' => 'Редактировать страницу', 'url' => $this->createUrl('/page/admin/page/update', ['id' => $page->id])];
        }
    }
    if (Yii::app()->moduleManager->allowed('blog') && Yii::app()->moduleManager->allowed('comment')) {
        $this->params['admin'] = array_merge($this->params['admin'] ?? [], Yii::app()->moduleManager->notifications($this->module->id));
    }
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
