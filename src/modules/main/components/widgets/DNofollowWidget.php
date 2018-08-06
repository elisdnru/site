<?php

class DNofollowWidget extends DWidget
{
    public function init()
    {
        ob_start();
        ob_implicit_flush(false);
    }

    public function run()
    {
        $html = ob_get_clean();
        $html = preg_replace('#<a(\s([^>]+))?\srel="[^"]*"#is', '<a$1', $html);
        $html = str_replace('<a ', '<a rel="nofollow" ', $html);
        echo $html;
    }
}
