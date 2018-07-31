<?php
declare(strict_types=1);

use Planet\Application\Action\Forecast\GetForecast;

$app->get('/clima', GetForecast::class);