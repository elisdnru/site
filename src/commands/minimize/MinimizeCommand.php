<?php

namespace app\commands\minimize;

use app\commands\minimize;
use app\components\ConsoleLogger;
use CConsoleCommand;
use Yii;

/**
 * Class MinimizeCommand
 *
 * <pre>
 * php yiic minimize all
 * </pre>
 */
class MinimizeCommand extends CConsoleCommand
{
    /**
     * @var \app\commands\minimize\Handler
     */
    private $handler;

    public function init()
    {
        $this->handler = new minimize\Handler(new minimize\FileDriver(), new ConsoleLogger());
    }

    public function actionIndex()
    {
        $success = true;
        $processor = new minimize\JSProcessor();
        foreach (Yii::app()->params['minimize_scripts'] as $target => $sources) {
            $success = $this->handler->from($sources)->with($processor)->to($target)->process() && $success;
        }
        return $success;
    }
}
