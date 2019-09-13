<?php

namespace app\components;

class ConsoleLogger implements Logger
{
    public function writeln($message = '')
    {
        $this->write($message);
        echo PHP_EOL;
    }

    public function write($message)
    {
        echo "\033[37m" . $message . " \033[m";
    }

    public function writelnSuccess($message = 'OK')
    {
        $this->writeSuccess($message);
        echo PHP_EOL;
    }

    public function writeSuccess($message = 'OK')
    {
        echo "\033[32m[" . $message . "] \033[m";
    }

    public function writelnError($message = 'FAIL')
    {
        $this->writeError($message);
        echo PHP_EOL;
    }

    public function writeError($message = 'FAIL')
    {
        echo "\033[31m[" . $message . "] \033[m";
    }

    public function writelnNotice($message)
    {
        $this->writeNotice($message);
        echo PHP_EOL;
    }

    public function writeNotice($message)
    {
        echo "\033[m" . $message . " \033[m";
    }
}
