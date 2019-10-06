<?php
# PHP Calendar (version 2.3), written by Keith Devens
# http://keithdevens.com/software/php_calendar
#  see example at http://keithdevens.com/weblog
# License: http://keithdevens.com/software/license

function generate_calendar($year, $month, $days = [], $day_name_length = 3, $month_href = null, $first_day = 0, $pn = [])
{
    $first_of_month = gmmktime(0, 0, 0, $month, 1, $year);

    $day_names = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
    $month_names = ['', 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];

    [$month, $year, $month_name, $weekday] = explode(',', gmstrftime('%m,%Y,%B,%w', $first_of_month));
    $weekday = ($weekday + 7 - $first_day) % 7;

    $title = $month_names[(int)$month] . '&nbsp;' . $year;

    $current_year = (int)date('Y');
    $current_month = (int)date('m');

    $enable_p = $year > $current_year - 1;
    $enable_n = $year < $current_year || $year == $current_year && $month < $current_month;

    @list($p, $pl) = $pn;
    @list($n, $nl) = $pn; #previous and next links, if applicable
    if ($p) {
        $p = '<span class="calendar-prev">' . ($pl && $enable_p ? '<span data-href="' . htmlspecialchars($pl) . '">' . $p . '</span>' : $p) . '</span>';
    }
    if ($n) {
        $n = '<span class="calendar-next">' . ($nl && $enable_n ? '<span data-href="' . htmlspecialchars($nl) . '">' . $n . '</span>' : $n) . '</span>';
    }
    $calendar = '<div class="calendar-month">' . $p . $n . ($month_href ? '<span data-href="' . htmlspecialchars($month_href) . '">' . $title . '</span>' : $title) . "</div>\n" . '<table><tr>';

    if ($day_name_length) { #if the day names should be shown ($day_name_length > 0)
        #if day_name_length is >3, the full name of the day will be printed
        foreach ($day_names as $d) {
            $calendar .= '<th>' . $d . '</th>';
        }
        $calendar .= "</tr>\n<tr>";
    }

    if ($weekday > 0) {
        $calendar .= '<td colspan="' . $weekday . '">&nbsp;</td>'; #initial 'empty' days
    }
    for ($day = 1, $days_in_month = gmdate('t', $first_of_month); $day <= $days_in_month; $day++, $weekday++) {
        if ($weekday == 7) {
            $weekday = 0; #start a new week
            $calendar .= "</tr>\n<tr>";
        }
        if (isset($days[$day]) and is_array($days[$day])) {
            @list($link, $classes, $content) = $days[$day];
            if ($content === null) {
                $content = $day;
            }
            $calendar .= '<td' . ($classes ? ' class="' . htmlspecialchars($classes) . '">' : '>') .
                ($link ? '<span data-href="' . htmlspecialchars($link) . '">' . $content . '</span>' : $content) . '</td>';
        } else {
            $calendar .= "<td>$day</td>";
        }
    }
    if ($weekday != 7) {
        $calendar .= '<td colspan="' . (7 - $weekday) . '">&nbsp;</td>';
    }

    return $calendar . "</tr>\n</table>\n";
}
