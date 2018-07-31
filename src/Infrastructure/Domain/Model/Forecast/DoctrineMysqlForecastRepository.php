<?php
declare(strict_types=1);

namespace Planet\Infrastructure\Domain\Model\Forecast;

use Planet\Domain\Model\Forecast\Forecast;
use Planet\Domain\Model\Forecast\ForecastRepository;
use Planet\Infrastructure\Domain\Model\DoctrineMysqlRepository;

class DoctrineMysqlForecastRepository extends DoctrineMysqlRepository implements ForecastRepository
{
    /**
     * @param Forecast $forecast
     */
    public function add(Forecast $forecast)
    {
        $this->em->persist($forecast);
    }

    /**
     * @param int $day
     * @return mixed
     */
    public function findByDay(int $day = 1)
    {
        return $this->em->getRepository(Forecast::class)->findBy(['day' => $day], [], 1);
    }
}
