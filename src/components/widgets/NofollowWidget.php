<?php

namespace app\components\widgets;

class NofollowWidget extends Widget
{
    public function init(): void
    {
        ob_start();
        ob_implicit_flush(false);
    }

    public function run(): void
    {
        $html = ob_get_clean();
        $html = preg_replace('#<a(\s([^>]+))?\srel="[^"]*"#is', '<a$1', $html);
        $html = str_replace('<a ', '<a rel="nofollow" ', $html);
        echo $html;
    }
}
