<?php
# PHP Calendar (version 2.3), written by Keith Devens
# http://keithdevens.com/software/php_calendar
#  see example at http://keithdevens.com/weblog
# License: http://keithdevens.com/software/license

function generate_calendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array()){
    $first_of_month = gmmktime(0,0,0,$month,1,$year);

    $day_names = array('Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс');
    $month_names = array('', 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');

    list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));
    $weekday = ($weekday + 7 - $first_day) % 7;

    $title   = $month_names[(int)$month].'&nbsp;'.$year;

	$current_year = (int)date('Y');
	$current_month = (int)date('m');

	$enable_p = $year > $current_year - 1;
	$enable_n = $year < $current_year || $year == $current_year && $month < $current_month;

    @list($p, $pl) = each($pn); @list($n, $nl) = each($pn); #previous and next links, if applicable
    if($p) $p = '<span class="calendar-prev">'.($pl && $enable_p ? '<a rel="nofollow" href="'.htmlspecialchars($pl).'">'.$p.'</a>' : $p).'</span>';
    if($n) $n = '<span class="calendar-next">'.($nl && $enable_n ? '<a rel="nofollow" href="'.htmlspecialchars($nl).'">'.$n.'</a>' : $n).'</span>';
    $calendar = '<div class="calendar-month">'.$p.$n.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title)."</div>\n".'<table><tr>';

    if($day_name_length){ #if the day names should be shown ($day_name_length > 0)
        #if day_name_length is >3, the full name of the day will be printed
        foreach($day_names as $d)
            $calendar .= '<th>'.$d.'</th>';
        $calendar .= "</tr>\n<tr>";
    }

    if($weekday > 0) $calendar .= '<td colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days
    for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){
        if($weekday == 7){
            $weekday   = 0; #start a new week
            $calendar .= "</tr>\n<tr>";
        }
        if(isset($days[$day]) and is_array($days[$day])){
            @list($link, $classes, $content) = $days[$day];
            if(is_null($content))  $content  = $day;
            $calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes).'">' : '>').
                ($link ? '<a href="'.htmlspecialchars($link).'">'.$content.'</a>' : $content).'</td>';
        }
        else $calendar .= "<td>$day</td>";
    }
    if($weekday != 7) $calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days

    return $calendar."</tr>\n</table>\n";
}
?>