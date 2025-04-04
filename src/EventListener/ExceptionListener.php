<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\SerializerInterface;

class ExceptionListener
{

    public function __construct
    (
        private readonly  SerializerInterface $serializer
    )

    {

    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getException();

        if ('App\Exceptions\ApiException' !== get_class($exception)) {
            return $exception;
        }

        $response = ['code' => $exception->getCode(),
                     'message' => $exception->getMessage(),
        ];
        $serialiseResponse = $this->serializer->serialize($response, 'json');
        $jsonResponse = new JsonResponse($serialiseResponse, $exception->getCode(), [], true);
        $event->setResponse($jsonResponse);
    }
}
