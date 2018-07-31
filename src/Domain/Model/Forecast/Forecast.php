<?php
declare(strict_types=1);

namespace Planet\Domain\Model\Forecast;

use Planet\Infrastructure\Service\MathService;
use Planet\Domain\Model\Ferengi\Ferengi;
use Planet\Domain\Model\Betasoide\Betasoide;
use Planet\Domain\Model\Vulcano\Vulcano;

class Forecast extends MathService
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $day;

    /**
     * @var string
     */
    private $weather;

    /**
     * @var Ferengi
     */
    private $ferengi;

    /**
     * @var Betasoide
     */
    private $betasoide;

    /**
     * @var Vulcano
     */
    private $vulcano;

    /**
     * Forecast constructor.
     * @param Ferengi $ferengi
     * @param Betasoide $betasoide
     * @param Vulcano $vulcano
     */
    public function __construct(Ferengi $ferengi, Betasoide $betasoide, Vulcano $vulcano)
    {
        $this->ferengi = $ferengi;
        $this->betasoide = $betasoide;
        $this->vulcano = $vulcano;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $day
     * @return Forecast
     */
    public function setDay(int $day) : Forecast
    {
        $this->day = $day;
        return $this;
    }

    /**
     * @return int
     */
    public function getDay() : int
    {
        return $this->day;
    }

    /**
     * @param string $weather
     * @return Forecast
     */
    public function setWeather(string $weather) : Forecast
    {
        $this->weather = $weather;
        return $this;
    }

    /**
     * @return string
     */
    public function getWeather() : string
    {
        return $this->weather;
    }

    /**
     * @return bool
     */
    public function isDrought() : bool
    {
        return ($this->ferengi->getPosition() - $this->betasoide->getPosition() == 0 || abs($this->ferengi->getPosition() - $this->betasoide->getPosition()) == 180) &&
            ($this->ferengi->getPosition() - $this->vulcano->getPosition() == 0 || abs($this->ferengi->getPosition() - $this->vulcano->getPosition()) == 180);
    }

    /**
     * @return bool
     */
    public function isRainy() : bool
    {
        $min = ($this->ferengi->getPosition() + 180) % 360;
        $max = ($this->betasoide->getPosition() + 180) % 360;
        if ($min < $max) {
            return $this->angleBetween($this->vulcano->getPosition(), $min, $max);
        } else {
            return $this->angleBetween($this->vulcano->getPosition(), $max, $min);
        }
    }

    /**
     * @return bool
     */
    public function isOptimal() : bool
    {
        return !$this->isDrought() && $this->isColineal($this->ferengi, $this->betasoide, $this->vulcano);
    }
}

