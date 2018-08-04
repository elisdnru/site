
<div class="Calendar">
    <?php
    include_once(__DIR__ . '/generate_calendar.php');
    echo generate_calendar($year, $month, $days, $len, $url, 1, $pnc);
    ?>
</div>