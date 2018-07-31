<?php
declare(strict_types=1);

namespace Planet\Domain\Model\Vulcano;

use Planet\Domain\Model\Planet\Planet;
use Planet\Infrastructure\Service\MathService;

class Vulcano extends Planet
{
    /**
     * @var MathService
     */
    private $mathService;

    /**
     * Vulcano constructor.
     * @param MathService $mathService
     */
    public function __construct(MathService $mathService)
    {
        $this->setName('Vulcano');
        $this->setPosition(0);
        $this->setSpeed(5);
        $this->setDistance(1000);

        $this->mathService = $mathService;
    }

    /**
     * moveOneDay
     */
    public function moveOneDay()
    {
        $this->setPosition($this->mathService->fixLimit($this->getPosition() + $this->getSpeed()));
    }
}

