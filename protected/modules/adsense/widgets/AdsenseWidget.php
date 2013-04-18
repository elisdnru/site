<?php

class AdsenseWidget extends DWidget
{
    public $tpl = 'default';

    public function run()
    {
        $this->render($this->tpl);
    }
}
