<?php
declare(strict_types=1);

namespace Planet\Domain\Model\Ferengi;
use Planet\Domain\Model\Planet\Planet;
use Planet\Infrastructure\Service\MathService;

class Ferengi extends Planet
{
    /**
     * @var MathService
     */
    private $mathService;

    /**
     * Ferengi constructor.
     * @param MathService $mathService
     */
    public function __construct(MathService $mathService)
    {
        $this->setName('Ferengi');
        $this->setPosition(360);
        $this->setSpeed(1);
        $this->setDistance(500);

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

