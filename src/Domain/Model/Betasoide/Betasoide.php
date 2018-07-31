<?php
declare(strict_types=1);

namespace Planet\Domain\Model\Betasoide;

use Planet\Domain\Model\Planet\Planet;
use Planet\Infrastructure\Service\MathService;

class Betasoide extends Planet
{
    /**
     * @var MathService
     */
    private $mathService;

    /**
     * Betasoide constructor.
     * @param MathService $mathService
     */
    public function __construct(MathService $mathService)
    {
        $this->setName('Betasoide');
        $this->setPosition(360);
        $this->setSpeed(3);
        $this->setDistance(2000);

        $this->mathService = $mathService;
    }

    /**
     * moveOneDay
     */
    public function moveOneDay()
    {
        $this->setPosition($this->mathService->fixLimit($this->getPosition() - $this->getSpeed()));
    }
}

