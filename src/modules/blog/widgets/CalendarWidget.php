<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Post;
use CHtml;
use app\extensions\cachetagging\Tags;
use yii\base\Widget;

class CalendarWidget extends Widget
{
    public function run(): string
    {
        if (!empty($_GET['date'])) {
            $month = date('m', strtotime($_GET['date']));
            $year = date('Y', strtotime($_GET['date']));
        } else {
            $month = date('m');
            $year = date('Y');
        }

        $firstDay = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
        $firstDayNextMonth = date('Y-m-d', mktime(0, 0, 0, $month + 1, 1, $year));
        $prevMonth = date('Y-m', mktime(0, 0, 0, $month - 1, 1, $year));
        $nextMonth = date('Y-m', mktime(0, 0, 0, $month + 1, 1, $year));

        $pnc = ['&lt;' => CHtml::normalizeUrl(['/blog/default/date', 'date' => $prevMonth]),
            '&gt;' => CHtml::normalizeUrl(['/blog/default/date', 'date' => $nextMonth])];

        // Today
        $days = [];
        $now = time();

        if ($firstDay <= $now && $now < $firstDayNextMonth) {
            $today = date('j');
            $days[$today] = [null, null, '<span id="today">' . $today . '</span>'];
        }

        // Make the links
        $posts = Post::model()->cache(0, new Tags('blog'))->published()->findAll([
            'condition' => 'date LIKE :date',
            'params' => [':date' => "$year-$month-%"],
        ]);

        foreach ($posts as $post) {
            $postTime = strtotime($post->date);
            $days[date('j', $postTime)] = [CHtml::normalizeUrl(['/blog/default/date', 'date' => date('Y-m-d', $postTime)]), 'linked-day'];
        }

        $len = 2;

        return $this->render('Calendar/calendar', [
            'year' => $year,
            'month' => $month,
            'days' => $days,
            'len' => $len,
            'url' => '',
            'pnc' => $pnc
        ]);
    }
}
