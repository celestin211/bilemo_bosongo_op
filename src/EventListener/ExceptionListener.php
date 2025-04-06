<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\SerializerInterface;

class ExceptionListener
{
    private readonly SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        // Get the exception from the event
        $exception = $event->getThrowable(); // Use getThrowable() instead of getException()

        if ('App\Exceptions\ApiException' !== get_class($exception)) {
            return; // Stop the processing if it's not ApiException
        }

        // Prepare the response data
        $response = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
        ];

        // Serialize the response
        $serialiseResponse = $this->serializer->serialize($response, 'json');

        // Create a JsonResponse
        $jsonResponse = new JsonResponse($serialiseResponse, $exception->getCode(), [], true);

        // Set the response for the event
        $event->setResponse($jsonResponse);
    }
}

