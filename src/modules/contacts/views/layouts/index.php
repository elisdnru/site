<?php declare(strict_types=1);

use app\widgets\Breadcrumbs;
use app\widgets\Messages;
use yii\web\View;

/**
 * @var View $this
 * @var string $content
 */
$this->beginContent('@app/views/layouts/main.php');
?>

<section class="main">

    <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]); ?>
    <?= Messages::widget(); ?>

    <?= $content; ?>

</section>
<?php $this->endContent(); ?>
