<?php
class CacheCommand extends CConsoleCommand
{
	public function actionClear() {
		Yii::app()->cache->flush();
		echo 'The cache is cleared' . PHP_EOL;
	}
}
