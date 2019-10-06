<?php

namespace app\components\behaviors;

use CBehavior;
use CHttpException;
use DateTime;
use Yii;

class TimeBehavior extends CBehavior
{
    public function checkTime()
    {
        $expires = $this->getExpires();

        if ($expires < 0) {
            throw new CHttpException(403, 'Демонстрационный режим работы сайта истёк');
        }

        Yii::app()->user->setFlash('warning', '<!doctype html><p style="position:fixed; z-index:200; width:100%; background:#f66; color:#fff; padding:5px 0; text-align:center;">До окончания демо-срока работы сайта осталось ' . $expires . ' дн.</p>');
    }

    public function getExpires()
    {
        $datetime1 = new DateTime(date('Y-m-d'));
        $datetime2 = new DateTime('2012-11-22');
        $interval = $datetime1->diff($datetime2);
        return $interval->format('%r%a');
    }
}
