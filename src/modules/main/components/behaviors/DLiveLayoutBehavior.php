<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */
class DLiveLayoutBehavior extends CBehavior
{
	public function initLayout()
	{
		$owner = $this->getOwner(); /* @var CController $owner */

		if (empty($owner->layout))
		{
			$module = $owner->getModule()->getId();
			$controller = $owner->getId();
			$action = $owner->getAction()->getId();

			$cacheId = "layout_{$module}_{$controller}_{$action}";

			if (!$owner->layout = Yii::app()->cache->get($cacheId))
			{
				$layouts = array(
					"application.modules.{$module}.views.layouts.{$module}_{$controller}_{$action}",
					"application.modules.{$module}.views.layouts.{$module}_{$controller}",
					"application.modules.{$module}.views.layouts.{$module}",
					"application.views.layouts.page.default",
				);

				foreach ($layouts as $layout)
				{
					if (file_exists(Yii::getPathOfAlias($layout) . '.php'))
					{
						$owner->layout = $layout;
						break;
					}
				}

				Yii::app()->cache->set($cacheId, $owner->layout, 3600 * 24);
			}
		}
	}
}