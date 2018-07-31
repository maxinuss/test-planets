<?php
declare(strict_types=1);

namespace Tests\Unit\User;

use Planet\Domain\Model\Vulcano\Vulcano;
use Planet\Infrastructure\Service\MathService;

class VulcanoTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function testTweetClass()
    {
        $mathService = new MathService();

        $vulcano = new Vulcano($mathService);
        $vulcano->setPosition(0);
        $vulcano->setDistance(100);
        $vulcano->setName('A');
        $vulcano->setSpeed(30);

        $this->assertInstanceOf('Planet\Domain\Model\Vulcano\Vulcano', $vulcano);
    }

    public function tearDown() {

    }
}
