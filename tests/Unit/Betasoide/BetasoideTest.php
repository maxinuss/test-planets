<?php
declare(strict_types=1);

namespace Tests\Unit\User;

use Planet\Domain\Model\Betasoide\Betasoide;
use Planet\Infrastructure\Service\MathService;

class BetasoideTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function testTweetClass()
    {
        $mathService = new MathService();

        $betasoide = new Betasoide($mathService);
        $betasoide->setPosition(0);
        $betasoide->setDistance(100);
        $betasoide->setName('A');
        $betasoide->setSpeed(30);

        $this->assertInstanceOf('Planet\Domain\Model\Betasoide\Betasoide', $betasoide);
    }

    public function tearDown() {

    }
}
