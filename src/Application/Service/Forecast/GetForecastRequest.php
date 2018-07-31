<?php
declare(strict_types=1);

namespace Planet\Application\Service\Forecast;

class GetForecastRequest
{
    /**
     * @var integer
     */
    private $day;

    /**
     * GetForecastRequest constructor.
     * @param int $day
     */
    public function __construct(int $day)
    {
        $this->day = $day;
    }

    /**
     * @return int
     */
    public function getDay() : int
    {
        return $this->day;
    }
}

