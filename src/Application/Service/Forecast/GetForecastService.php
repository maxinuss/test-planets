<?php
declare(strict_types=1);

namespace Planet\Application\Service\Forecast;

use Planet\Domain\Model\Forecast\ForecastRepository;
use Planet\Infrastructure\Service\JsonTransformer;
use Planet\Infrastructure\Transformer\ForecastTransformer;


class GetForecastService
{
    /**
     * @var ForecastRepository
     */
    private $forecastRepository;

    /**
     * @var JsonTransformer
     */
    private $jsonTransformer;

    /**
     * GetForecastService constructor.
     * @param ForecastRepository $forecastRepository
     * @param JsonTransformer $jsonTransformer
     */
    public function __construct(
        ForecastRepository $forecastRepository,
        JsonTransformer $jsonTransformer
    ) {
        $this->forecastRepository = $forecastRepository;
        $this->jsonTransformer = $jsonTransformer;
    }

    /**
     * @param GetForecastRequest $request
     * @return array
     */
    public function execute(GetForecastRequest $request)
    {
        try{
            $forecast = $this->forecastRepository->findByDay($request->getDay());
            return $this->jsonTransformer->formatItem($forecast[0], new ForecastTransformer());

        }catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
