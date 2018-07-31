<?php
declare(strict_types=1);

namespace Planet\Infrastructure\Service;

use Planet\Domain\Model\Ferengi\Ferengi;
use Planet\Domain\Model\Betasoide\Betasoide;
use Planet\Domain\Model\Vulcano\Vulcano;

class MathService
{
    /**
     * @param Ferengi $ferengi
     * @param Betasoide $betasoide
     * @param Vulcano $vulcano
     * @return bool
     */
    public function isColineal(Ferengi $ferengi, Betasoide $betasoide, Vulcano $vulcano)
    {
        $distances = [];

        $distances[] = $this->getPointsDistance($ferengi->getDistance(), $betasoide->getDistance(), $ferengi->getPosition(), $betasoide->getPosition());
        $distances[] = $this->getPointsDistance($betasoide->getDistance(), $vulcano->getDistance(), $betasoide->getPosition(), $vulcano->getPosition());
        $distances[] = $this->getPointsDistance($ferengi->getDistance(), $vulcano->getDistance(), $ferengi->getPosition(), $vulcano->getPosition());

        sort($distances);

        $min = $distances[0];
        $middle = $distances[1];
        $max = $distances[2];

        return $max == $min + $middle;
    }

    /**
     * @param $value
     * @param $min
     * @param $max
     * @return bool
     */
    public function angleBetween($value, $min, $max){
        if ($max - $min > 180){
            if ($value < $min)
                $value += 360;
            $min = $min + 360;
            $aux = $max;
            $max = $min;
            $min = $aux;
        }
        return ($value > $min && $value < $max);
    }

    /**
     * @param $value
     * @return int
     */
    public function fixLimit($value)
    {
        if($value > 360) {
            return $value - 360;
        }

        if($value < 0) {
            return  $value + 360;
        }

        return $value;
    }

    /**
     * @param $distance1
     * @param $distance2
     * @param $angle1
     * @param $angle2
     * @return float
     */
    private function getPointsDistance($distance1, $distance2, $angle1, $angle2)
    {
        return  round(sqrt(pow($distance1, 2) + pow($distance2, 2) - 2 * $distance1 * $distance2 * cos(deg2rad($angle1 - $angle2))));
    }

    /**
     * @param Ferengi $ferengi
     * @param Betasoide $betasoide
     * @param Vulcano $vulcano
     * @return float
     */
    public function getPerimeter(Ferengi $ferengi, Betasoide $betasoide, Vulcano $vulcano)
    {
        $perimeter = $this->getPointsDistance($ferengi->getDistance(), $betasoide->getDistance(), $ferengi->getPosition(), $betasoide->getPosition());
        $perimeter += $this->getPointsDistance($betasoide->getDistance(), $vulcano->getDistance(), $betasoide->getPosition(), $vulcano->getPosition());
        $perimeter += $this->getPointsDistance($ferengi->getDistance(), $vulcano->getDistance(), $ferengi->getPosition(), $vulcano->getPosition());

        return $perimeter;
    }
}

