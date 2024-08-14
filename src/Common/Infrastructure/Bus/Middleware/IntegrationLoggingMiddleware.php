<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\Middleware;

use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

#[WithMonologChannel('integration')]
class IntegrationLoggingMiddleware implements MiddlewareInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        try {
            $envelope = $stack->next()->handle($envelope, $stack);
        } catch (HandlerFailedException $e) {
            $this->logger->critical('An error occurred during async message processing', [
                'exception' => $e,
                'message' => $envelope->getMessage(),
            ]);

            throw $e;
        }

        return $envelope;
    }
}
