<?php

declare(strict_types=1);

namespace app\extensions\ixr;

/**
 * IXR_Base64
 *
 * @package IXR
 * @since 1.5
 */
class Base64
{
    var $data;

    function __construct($data)
    {
        $this->data = $data;
    }

    function getXml()
    {
        return '<base64>' . base64_encode($this->data) . '</base64>';
    }
}
