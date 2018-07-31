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

class GetFerengiPredictionCommand extends Command
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
    public function __construct(?string $name = null, Ferengi $ferengi, Betasoide $betasoide, Vulcano $vulcano)
    {
        parent::__construct($name);

        $this->ferengi = $ferengi;
        $this->betasoide = $betasoide;
        $this->vulcano = $vulcano;
        $this->mathService = new MathService();
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this->setName('predictions:ferengi');
        $this->setDescription('Get Ferengi weather predictions for 10 years');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $drought = 0;
        $rainy = 0;
        $optimal = 0;
        $perimeters = [];

        $yearsToForecast = 10;
        for($i = 1; $i < ($this->ferengi->getYearDays() * $yearsToForecast) + 1; $i++) {

            $this->ferengi->moveOneDay();
            $this->betasoide->moveOneDay();
            $this->vulcano->moveOneDay();

            $forecast = new Forecast($this->ferengi, $this->betasoide, $this->vulcano);

            if($forecast->isDrought()) {
                $drought++;
            }

            if($forecast->isRainy()) {
                $rainy++;
            }

            if($forecast->isOptimal()) {
                $optimal++;
            }

            $perimeters[] = [
                'perimeter' => $this->mathService->getPerimeter($this->ferengi, $this->betasoide, $this->vulcano),
                'day' => $i
            ];
        }

        $maxPerimeter = max($perimeters);
        $maxPerimeterDays = [];
        foreach($perimeters as $p) {
            if($p['perimeter'] == $maxPerimeter['perimeter']) {
                $maxPerimeterDays[] = $p['day'];
            }
        }

        $maxRainyDays = implode(',', $maxPerimeterDays);

        echo "\nPeriods for Ferengui \n\n";
        echo "Drought periods: {$drought} \n";
        echo "Rainy periods: {$rainy} \n";
        echo "Max Rainy days: {$maxRainyDays} \n";
        echo "Optimal periods: {$optimal} \n\n";

        return 1;
    }
}