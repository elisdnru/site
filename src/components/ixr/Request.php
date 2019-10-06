<?php

declare(strict_types=1);

namespace app\components\ixr;

/**
 * IXR_Request
 *
 * @package IXR
 * @since 1.5
 */
class Request
{
    var $method;
    var $args;
    var $xml;

    function __construct($method, $args)
    {
        $this->method = $method;
        $this->args = $args;
        $this->xml = <<<EOD
<?xml version="1.0"?>
<methodCall>
<methodName>{$this->method}</methodName>
<params>

EOD;
        foreach ($this->args as $arg) {
            $this->xml .= '<param><value>';
            $v = new Value($arg);
            $this->xml .= $v->getXml();
            $this->xml .= "</value></param>\n";
        }
        $this->xml .= '</params></methodCall>';
    }

    function getLength()
    {
        return strlen($this->xml);
    }

    function getXml()
    {
        return $this->xml;
    }
}
