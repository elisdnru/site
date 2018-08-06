<?php

Yii::import('application.modules.blog.models.*');
DUrlRulesHelper::import('blog');

class BlogCalendarWidget extends DWidget
{
    public $title = 'Calendar';

    public function run()
    {
        // Prepare the css style within the calendar widget
        $url = CHtml::asset(Yii::getPathOfAlias('blog.widgets.views.Calendar.calendar') . '.css');
        Yii::app()->clientScript->registerCssFile($url);

        if (!empty($_GET['date'])) {
            $month = date('m', strtotime($_GET['date']));
            $year = date('Y', strtotime($_GET['date']));
        } else {
            $month = date('m');
            $year = date('Y');
        }

        $firstDay = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
        $firstDayPrevMonth = date('Y-m-d', mktime(0, 0, 0, $month - 1, 1, $year));
        $firstDayNextMonth = date('Y-m-d', mktime(0, 0, 0, $month + 1, 1, $year));
        $prevMonth = date('Y-m', mktime(0, 0, 0, $month - 1, 1, $year));
        $nextMonth = date('Y-m', mktime(0, 0, 0, $month + 1, 1, $year));

        $pnc = ['&lt;' => CHtml::normalizeUrl(['/blog/default/date', 'date' => $prevMonth]),
            '&gt;' => CHtml::normalizeUrl(['/blog/default/date', 'date' => $nextMonth])];

        // Today
        $days = [];
        if ($firstDay <= time() && time() < $firstDayNextMonth) {
            $today = date('j', time());
            $days[$today] = [null, null, '<span id="today">' . $today . '</span>'];
        }

        // Make the links
        $posts = BlogPost::model()->cache(0, new Tags('blog'))->published()->findAll([
            'condition' => 'date LIKE :date',
            'params' => [':date' => "$year-$month-%"],
        ]);

        foreach ($posts as $post) {
            $days[date('j', strtotime($post->date))] = [CHtml::normalizeUrl(['/blog/default/date', 'date' => date('Y-m-d', strtotime($post->date))]), 'linked-day'];
        }

        if (isset($locale) && $locale == 'ja_JP.utf8') {
            $len = 3;
        } else {
            $len = 2;
        }

        $this->render('Calendar/calendar', [
            'year' => $year,
            'month' => $month,
            'days' => $days,
            'len' => $len,
            'url' => '',
            'pnc' => $pnc
        ]);
    }
}
