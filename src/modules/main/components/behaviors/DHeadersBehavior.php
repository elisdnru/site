<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

class DHeadersBehavior extends CBehavior
{
    public function initHeaders()
    {
        header('X-Programmer: ElisDN');
    }
}
