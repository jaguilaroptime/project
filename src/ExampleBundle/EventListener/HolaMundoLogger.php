<?php

namespace ExampleBundle\EventListener;

class HolaMundoLogger
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function agregarMensajeAlLoger()
    {
        $this->logger->info("Hola Mundo");
        $this->logger->debug("Hola Mundo");
    }
}