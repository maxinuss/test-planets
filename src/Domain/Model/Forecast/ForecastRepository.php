<?php
declare(strict_types=1);

namespace Planet\Domain\Model\Forecast;

interface ForecastRepository
{
    /**
     * @param Forecast $forecast
     */
    public function add(Forecast $forecast);

    /**
     * @param int $day
     * @return mixed
     */
    public function findByDay(int $day);
}
