<?php
declare(strict_types=1);

namespace Planet\Infrastructure\Transformer;

use Planet\Domain\Model\Forecast\Forecast;
use League\Fractal\TransformerAbstract;

class ForecastTransformer extends TransformerAbstract
{
    /**
     * @param Forecast $forecast
     * @return array
     */
    public function transform(Forecast $forecast)
    {
        return [
            'dia' => $forecast->getDay(),
            'clima' => $forecast->getWeather()
        ];
    }
}


