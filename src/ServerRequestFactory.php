<?php

namespace Http\Factory\Diactoros;

use Interop\Http\Factory\ServerRequestFactoryInterface;
use Interop\Http\Factory\ServerRequestFromGlobalsFactoryInterface;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\ServerRequestFactory as Factory;

class ServerRequestFactory implements ServerRequestFactoryInterface
{
    public function createServerRequest(array $server, $method = null, $uri = null)
    {
        $server  = Factory::normalizeServer($server ?: $_SERVER);
        $files   = Factory::normalizeFiles($files ?: $_FILES);
        $headers = Factory::marshalHeaders($server);

        if (empty($method)) {
            $method = Factory::get('REQUEST_METHOD', $server, 'GET');
        }

        if (empty($uri)) {
            $uri = Factory::marshalUriFromServer($server, $headers);
        }

        return new ServerRequest(
            $server,
            $files,
            $uri,
            $method,
            'php://input',
            $headers,
            $_COOKIE,
            $_GET,
            $_POST,
            static::marshalProtocolVersion($server)
        );
    }
}
