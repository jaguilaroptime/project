<?php

namespace AppBundle\Service;

use Psr\Log\LoggerInterface;

class MessageGenerator
{
    private $logger;

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->logger->info('I just got the logger');
    }

    // ...
}