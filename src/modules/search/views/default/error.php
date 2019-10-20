<?php
/** @var $this Controller */

use app\components\Controller;
use app\modules\user\models\Access;

/** @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'Поиск по сайту';
$this->description = 'Поиск по сайту';

$this->params['breadcrumbs'] = [
    'Поиск по сайту',
];

if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
    if (Yii::app()->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post')];
    }
    if (Yii::app()->moduleManager->allowed('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => $this->createUrl('/page/admin/page')];
    }
}
?>

<h1>Поиск по сайту</h1>

<?php $this->widget(\app\modules\search\widgets\SearchFormWidget::class); ?>

<p>Введите запрос</p>
