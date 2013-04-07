<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

class DExistOrEmpty extends CExistValidator
{
    protected function isEmpty($value, $trim=false)
    {
        return !$value || parent::isEmpty($value, $trim);
    }
}