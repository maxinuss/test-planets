<?php
declare(strict_types=1);

namespace Planet\Application;

class TimezoneHandler
{
    /**
     * @var string
     */
    private $timezone;

    /**
     * TimezoneHandler constructor.
     * @param string $timezone
     */
    public function __construct(string $timezone)
    {
        $this->timezone = $timezone;
        date_default_timezone_set($this->timezone);
    }

    /**
     * @return string
     */
    public function getTimezone() : string
    {
        return $this->timezone;
    }
}