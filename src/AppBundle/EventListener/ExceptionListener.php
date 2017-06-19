<?php
namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        //dump($exception);die();
        $message = sprintf(
            'Mi error dice: %s en el código: %s',
            $exception->getMessage(),
            $exception->getCode()
        );

        // Customiza tu response object para mostrar los detalles de excepción
        $response = new Response();
        $response->setContent($message);

        // HttpExceptionInterface es un tipo especial de excepción
        // que mantiene los detalles de header y código de estado
        if($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Enviar el objeto Response modificado al evento
        $event->setResponse($response);
    }
}