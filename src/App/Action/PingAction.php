<?php

namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

class PingAction implements ServerMiddlewareInterface
{
    /**
     * @param $host
     * @param int $port
     * @param int $timeout
     * @return bool
     */
    private function ping($host,$port=80,$timeout=5)
    {
        $fsock = @fsockopen($host, $port, $errno, $errstr, $timeout);
        if ( ! $fsock ) {
            return false;
        } else
        {
            return true;
        }
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {

        return new JsonResponse([
            'ack'  => time(),
            'ping' => $this->ping('www.google.com',80,5)
        ]);
        
    }
}
