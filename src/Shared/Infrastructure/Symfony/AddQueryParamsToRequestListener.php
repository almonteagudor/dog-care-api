<?php

declare(strict_types=1);

namespace DogCare\Shared\Infrastructure\Symfony;

use InvalidArgumentException;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class AddQueryParamsToRequestListener
{
    private QueryParamsValidator $validator;

    public function __construct(QueryParamsValidator $validator)
    {
        $this->validator = $validator;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $data = $request->query->all();

        try {
            $data['filters'] = $this->validator->validateFilters(
                $request->get('filters')
                    ? json_decode(urldecode($request->get('filters')), true, 512, JSON_THROW_ON_ERROR)
                    : [],
            );
            $data['orderBy'] = $this->validator->validateString($request->query->get('order_by'), 'orderBy');
            $data['order'] = $this->validator->validateOrder($request->query->get('order'));
            $data['limit'] = $this->validator->validateInt($request->query->get('limit'), 'limit');
            $data['offset'] = $this->validator->validateInt($request->query->get('offset'), 'offset');

            if (null === $data['limit'] && null !== $data['offset']) {
                throw new InvalidArgumentException('Missing "limit" parameter when "offset" is set.');
            }
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }

        $request->attributes->set('query_params', $data);
    }
}
