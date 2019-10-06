<?php
/**
 * IXR - The Incutio XML-RPC Library
 *
 * Copyright (c) 2010, Incutio Ltd.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *  - Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *  - Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *  - Neither the name of Incutio Ltd. nor the names of its contributors
 *    may be used to endorse or promote products derived from this software
 *    without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
 * IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY
 * OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE
 * USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @package IXR
 * @since 1.5
 *
 * @copyright  Incutio Ltd 2010 (http://www.incutio.com)
 * @version    1.7.4 7th September 2010
 * @author     Simon Willison
 * @link       http://scripts.incutio.com/xmlrpc/ Site/manual
 */

namespace app\extensions\ixr;

/**
 * Extension of the {@link IXR_Server} class to easily wrap objects.
 *
 * Class is designed to extend the existing XML-RPC server to allow the
 * presentation of methods from a variety of different objects via an
 * XML-RPC server.
 * It is intended to assist in organization of your XML-RPC methods by allowing
 * you to "write once" in your existing model classes and present them.
 *
 * @author Jason Stirk <jstirk@gmm.com.au>
 * @version 1.0.1 19Apr2005 17:40 +0800
 * @copyright Copyright (c) 2005 Jason Stirk
 * @package IXR
 */
class ClassServer extends Server
{
    var $_objects;
    var $_delim;

    function __construct($delim = '.', $wait = false)
    {
        parent::__construct([], false, $wait);
        $this->_delimiter = $delim;
        $this->_objects = [];
    }

    function addMethod($rpcName, $functionName)
    {
        $this->callbacks[$rpcName] = $functionName;
    }

    function registerObject($object, $methods, $prefix = null)
    {
        if ($prefix === null) {
            $prefix = get_class($object);
        }
        $this->_objects[$prefix] = $object;

        // Add to our callbacks array
        foreach ($methods as $method) {
            if (is_array($method)) {
                $targetMethod = $method[0];
                $method = $method[1];
            } else {
                $targetMethod = $method;
            }
            $this->callbacks[$prefix . $this->_delimiter . $method] = [$prefix, $targetMethod];
        }
    }

    function call($methodname, $args)
    {
        if (!$this->hasMethod($methodname)) {
            return new Error(-32601, 'server error. requested method ' . $methodname . ' does not exist.');
        }
        $method = $this->callbacks[$methodname];

        // Perform the callback and send the response
        if (count($args) === 1) {
            // If only one paramater just send that instead of the whole array
            $args = $args[0];
        }

        // See if this method comes from one of our objects or maybe self
        if (is_array($method) || (strpos($method, 'this:') === 0)) {
            if (is_array($method)) {
                $object = $this->_objects[$method[0]];
                $method = $method[1];
            } else {
                $object = $this;
                $method = substr($method, 5);
            }

            // It's a class method - check it exists
            if (!method_exists($object, $method)) {
                return new Error(-32601, 'server error. requested class method "' . $method . '" does not exist.');
            }

            // Call the method
            $result = $object->$method($args);
        } else {
            // It's a function - does it exist?
            if (!function_exists($method)) {
                return new Error(-32601, 'server error. requested function "' . $method . '" does not exist.');
            }

            // Call the function
            $result = $method($args);
        }
        return $result;
    }
}
