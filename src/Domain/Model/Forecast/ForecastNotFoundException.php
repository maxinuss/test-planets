<?php
declare(strict_types=1);

namespace Planet\Domain\Model\Forecast;

use Planet\Domain\Exception\NotFoundException;
use Throwable;

class ForecastNotFoundException extends \Exception implements NotFoundException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = "Forecast not found";
        parent::__construct($message, $code, $previous);
    }
}
