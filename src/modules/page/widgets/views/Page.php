<?php
/** @var $page Page */

use app\modules\page\models\Page;

?>
<?php echo Yii::app()->controller->decodeWidgets(trim($page->text_purified));
