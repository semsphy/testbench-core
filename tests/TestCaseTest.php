<?php

namespace Orchestra\Testbench\Tests;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Foundation\Application;
use function Orchestra\Testbench\container;
use Orchestra\Testbench\Contracts\TestCase as TestCaseContract;
use function Orchestra\Testbench\phpunit_version_compare;
use PHPUnit\Framework\TestCase;

class TestCaseTest extends TestCase
{
    /** @test */
    public function it_can_create_the_testcase()
    {
        $methodName = phpunit_version_compare('10', '>=')
            ? $this->name()
            : $this->getName();

        $testbench = new class($methodName) extends \Orchestra\Testbench\TestCase
        {
            //
        };

        $app = $testbench->createApplication();

        $this->assertInstanceOf(TestCaseContract::class, $testbench);
        $this->assertInstanceOf(Application::class, $app);
        $this->assertEquals('UTC', date_default_timezone_get());
        $this->assertEquals('testing', $app['env']);
        $this->assertInstanceOf(ConfigRepository::class, $app['config']);
    }

    /** @test */
    public function it_can_create_a_container()
    {
        $app = container()->createApplication();

        $this->assertInstanceOf(Application::class, $app);
        $this->assertEquals('UTC', date_default_timezone_get());
        $this->assertEquals('testing', $app['env']);
        $this->assertInstanceOf(ConfigRepository::class, $app['config']);
    }
}
