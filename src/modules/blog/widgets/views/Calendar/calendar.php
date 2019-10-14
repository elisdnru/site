<?php
/** @var $year int */
/** @var $month int */
/** @var $days int */
/** @var $len int */
/** @var $pnc array */
?>
<div class="calendar">
    <?php
    include_once(__DIR__ . '/generate_calendar.php');
    echo generate_calendar($year, $month, $days, $len, $url, 1, $pnc);
    ?>
</div>
