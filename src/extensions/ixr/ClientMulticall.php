<?php

declare(strict_types=1);

namespace app\extensions\ixr;

/**
 * IXR_ClientMulticall
 *
 * @package IXR
 * @since 1.5
 */
class ClientMulticall extends Client
{
    var $calls = [];

    function __construct($server, $path = false, $port = 80)
    {
        parent::__construct($server, $path, $port);
        $this->useragent = 'The Incutio XML-RPC PHP Library (multicall client)';
    }

    function addCall()
    {
        $args = func_get_args();
        $methodName = array_shift($args);
        $struct = [
            'methodName' => $methodName,
            'params' => $args
        ];
        $this->calls[] = $struct;
    }

    function query()
    {
        // Prepare multicall, then call the parent::query() method
        return parent::query('system.multicall', $this->calls);
    }
}
