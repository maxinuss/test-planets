<?php
declare(strict_types=1);

namespace Planet\Domain\Model\Planet;

abstract class Planet
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $distance;

    /**
     * @var int
     */
    private $position;
    
    /**
     * @var int
     */
    private $speed;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Planet
     */
    public function setName(string $name) : Planet
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getDistance() : float
    {
        return $this->distance;
    }

    /**
     * @param float $distance
     * @return Planet
     */
    public function setDistance(float $distance) : Planet
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition() : int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return Planet
     */
    public function setPosition(int $position) : Planet
    {
        $this->position = $position;
        return $this;
    }
    /**
     * @return int
     */
    public function getSpeed() : int
    {
        return $this->speed;
    }

    /**
     * @param int $speed
     * @return Planet
     */
    public function setSpeed(int $speed) : Planet
    {
        $this->speed = $speed;
        return $this;
    }

    /**
     * @return int
     */
    public function getYearDays() : int
    {
        return 360 / $this->getSpeed();
    }

    /**
     * moveOneDay
     */
    abstract public function moveOneDay();
}

