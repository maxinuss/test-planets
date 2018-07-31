<?php
declare(strict_types=1);

namespace Planet\Application\Action\Forecast;

use Planet\Application\Service\Forecast\GetForecastService;
use Planet\Application\Service\Forecast\GetForecastRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetForecast
{
    /**
     * @var GetForecastService
     */
    private $service;
    /**
     * @param GetForecastService $service
     */
    public function __construct(GetForecastService $service)
    {
        $this->service = $service;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args = []): ResponseInterface
    {
        $body = $request->getQueryParams();

        $result = $this->service->execute(
            new GetForecastRequest(
                (int) $body['dia'] ?? 1
            )
        );

        return $response->withJson($result);
    }
}
