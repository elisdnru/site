<?php


class DExistOrEmpty extends CExistValidator
{
    protected function isEmpty($value, $trim = false)
    {
        return !$value || parent::isEmpty($value, $trim);
    }
}
