<?php

declare(strict_types=1);

namespace DogCare\Shared\Infrastructure\Symfony;

use JsonException;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class AddJsonBodyToRequestListener
{
    /**
     * @throws JsonException
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $requestContents = $request->getContent();
        $data = [];
        $request->getContent();

        if (
            !empty($requestContents)
            && in_array($request->getMethod(), ['PATCH', 'PUT', 'POST'], true)
            && str_starts_with((string) $request->headers->get('Content-Type'), 'application/json')
        ) {
            $jsonData = json_decode($requestContents, true, 512, JSON_THROW_ON_ERROR);

            if (!$jsonData) {
                throw new BadRequestHttpException('Request body is empty or invalid.');
            }

            $jsonDataSnakeCase = [];
            foreach ($jsonData as $key => $value) {
                $jsonDataSnakeCase[(string) preg_replace_callback(
                    '/([A-Z])/',
                    static fn ($matches) => '_' . strtolower($matches[1]),
                    $key,
                )] = $value;
            }

            $data = $jsonDataSnakeCase;
        }

        $request->attributes->set('body', $data);
    }
}
