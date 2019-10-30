<?php

namespace Neat\Configuration\Test;

use Neat\Configuration\Environment;
use Neat\Configuration\Policy;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    /**
     * @return Policy|MockObject
     */
    protected function policy(): Policy
    {
        return $this->getMockBuilder(Policy::class)->setMethods(['setting'])->getMock();
    }

    /**
     * @return Environment|MockObject
     */
    protected function environment(): Environment
    {
        return $this->getMockBuilder(Environment::class)->setMethods(['query'])->getMock();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            [Stub\Name::class, 'TEST_', 'name', 'NAME', 'Testname', 'Testname'],
            [Stub\Integer::class, 'TEST_', 'integer', 'INTEGER', '9', 9],
            [Stub\Boolean::class, 'TEST_', 'boolean', 'BOOLEAN', '1', true],
        ];
    }

    /**
     * Test settings
     *
     * @dataProvider data
     * @param string $class
     * @param string $prefix
     * @param string $property
     * @param string $setting
     * @param string $value
     * @param mixed  $result
     */
    public function testSettings(string $class, string $prefix, string $property, string $setting, string $value, $result)
    {
        $policy = $this->policy();
        $policy
            ->expects($this->once())
            ->method('setting')
            ->with($property)
            ->willReturn($setting);

        $environment = $this->environment();
        $environment
            ->expects($this->once())
            ->method('query')
            ->with($prefix)
            ->willReturn([$setting => $value]);

        $settings = new $class($environment, $policy);

        $this->assertSame($result, $settings->$property);
    }

    /**
     * Test unknown setting
     */
    public function testUnknownSetting()
    {
        $policy = $this->policy();
        $policy
            ->expects($this->once())
            ->method('setting')
            ->with('unknown')
            ->willReturn('UNKNOWN');

        $environment = $this->environment();
        $environment
            ->expects($this->once())
            ->method('query')
            ->with('')
            ->willReturn([]);

        $settings = new Stub\Unknown($environment, $policy);

        $this->assertNull($settings->unknown);
    }

    /**
     * Test skip static setting
     */
    public function testSkipStaticSetting()
    {
        $policy = $this->policy();
        $policy
            ->expects($this->never())
            ->method('setting');

        $environment = $this->environment();
        $environment
            ->expects($this->once())
            ->method('query')
            ->with('')
            ->willReturn([]);

        new Stub\SkipStatic($environment, $policy);

        $this->addToAssertionCount(1);
    }
}
