<?php

namespace Http\Factory\Diactoros;

use Interop\Http\Factory\StreamFactoryInterface;
use Zend\Diactoros\Stream;

class StreamFactory implements StreamFactoryInterface
{
    public function createStream($content = '')
    {
        $resource = fopen('php://temp', 'w+');

        fwrite($resource, $content);

        return $this->createStreamFromResource($resource);
    }

    public function createStreamFromFile($file, $mode = 'r')
    {
        $resource = fopen($file, $mode);

        return $this->createStreamFromResource($resource);
    }

    public function createStreamFromResource($resource)
    {
        return new Stream($resource);
    }
}
