<?php

use app\assets\AdminAsset;
use app\widgets\Breadcrumbs;
use app\widgets\Messages;
use yii\web\View;

/**
 * @var View $this
 * @var string $content
 */

AdminAsset::register($this);
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<section class="main admin">

    <?= Breadcrumbs::widget([
        'links' => array_filter(array_merge(
            $this->context->route === 'admin/default/index' ? [] : ['Панель управления' => ['/admin']],
            $this->params['breadcrumbs']
        ))
    ]) ?>
    <?= Messages::widget() ?>

    <?= $content ?>

</section>

<?php $this->endContent(); ?>
