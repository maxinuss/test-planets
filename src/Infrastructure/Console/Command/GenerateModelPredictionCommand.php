<?php
declare(strict_types=1);

namespace Planet\Infrastructure\Console\Command;

use Planet\Infrastructure\Service\MathService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Planet\Domain\Model\Ferengi\Ferengi;
use Planet\Domain\Model\Betasoide\Betasoide;
use Planet\Domain\Model\Vulcano\Vulcano;
use Planet\Domain\Model\Forecast\Forecast;
use Planet\Domain\Model\Forecast\ForecastRepository;

class GenerateModelPredictionCommand extends Command
{
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
     * @var ForecastRepository
     */
    private $forecastRepository;
    /**
     * @var MathService
     */
    private $mathService;

    /**
     * GetFerengiPredictionCommand constructor.
     * @param null|string $name
     * @param Ferengi $ferengi
     * @param Betasoide $betasoide
     * @param Vulcano $vulcano
     */
    public function __construct(?string $name = null, Ferengi $ferengi, Betasoide $betasoide, Vulcano $vulcano, ForecastRepository $forecastRepository)
    {
        parent::__construct($name);

        $this->ferengi = $ferengi;
        $this->betasoide = $betasoide;
        $this->vulcano = $vulcano;
        $this->forecastRepository = $forecastRepository;

        $this->mathService = new MathService();
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this->setName('predictions:generate');
        $this->setDescription('Fill database with generated predictions for 10 years');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->forecastRepository->beginTransaction();
            $yearsToForecast = 10;
            for ($i = 1; $i < ($this->ferengi->getYearDays() * $yearsToForecast) + 1; $i++) {

                $this->ferengi->moveOneDay();
                $this->betasoide->moveOneDay();
                $this->vulcano->moveOneDay();

                $forecast = new Forecast($this->ferengi, $this->betasoide, $this->vulcano);
                $forecast->setDay($i);

                if ($forecast->isDrought()) {
                    $forecast->setWeather('sequía');
                } elseif ($forecast->isRainy()) {
                    $forecast->setWeather('lluvia');
                } elseif ($forecast->isOptimal()) {
                    $forecast->setWeather('optimo');
                } else {
                    $forecast->setWeather('normal');
                }

                $this->forecastRepository->add($forecast);
            }

            $this->forecastRepository->commit();
        } catch (\Exception $e) {
            $this->forecastRepository->rollBack();
        }

        return 1;
    }
}