<?php
declare(strict_types=1);

namespace Tests\Unit\User;

use Planet\Domain\Model\Ferengi\Ferengi;
use Planet\Infrastructure\Service\MathService;

class FerengiTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function testTweetClass()
    {
        $mathService = new MathService();

        $ferengi = new Ferengi($mathService);
        $ferengi->setPosition(0);
        $ferengi->setDistance(100);
        $ferengi->setName('A');
        $ferengi->setSpeed(30);

        $this->assertInstanceOf('Planet\Domain\Model\Ferengi\Ferengi', $ferengi);
    }

    public function tearDown() {

    }
}
