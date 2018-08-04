<?php

class DTimer
{
    protected static $startTime;
    protected static $points = array();

    public static function run()
    {
        self::$startTime = microtime(true);
    }

    public static function log($message='')
    {
        if (self::$startTime === null)
            self::run();

        self::$points[] = array('message'=>$message, 'time'=>sprintf('%0.3f', microtime(true) - self::$startTime));
    }

    public static function show()
    {
        $oldtime = 0;

        echo '
            <table style="width:auto !important; position:fixed; right:0; top:0; z-index:200; background:#fff !important">
             <tr>
                <th></th>
                <th>Diff</th>
                <th>Time</th>
            </tr>
        ';

        foreach(self::$points as $item){

            $message = $item['message'];
            $time = $item['time'] * 1000;
            $diff = ($item['time'] - $oldtime) * 1000;

            echo "
                <tr>
                    <td>{$message}</td>
                    <td style='text-align:right; width:50px'>{$diff}</td>
                    <td style='text-align:right; width:50px''>{$time}</td>
                </tr>
            ";

            $oldtime = $item['time'];
        };
        echo "</table>\n";
    }
}