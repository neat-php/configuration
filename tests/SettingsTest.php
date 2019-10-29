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
        return $this->getMockBuilder(Environment::class)->setMethods(['has', 'get'])->getMock();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            [Stub\Name::class, 'TEST_', 'name', 'TEST_NAME', 'Testname', 'Testname'],
            [Stub\Integer::class, 'TEST_', 'integer', 'TEST_INTEGER', '9', 9],
            [Stub\Boolean::class, 'TEST_', 'boolean', 'TEST_BOOLEAN', '1', true],
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
        $policy->expects($this->at(0))->method('setting')->with($prefix, $property)->willReturn($setting);

        $environment = $this->environment();
        $environment->expects($this->at(0))->method('has')->with($setting)->willReturn(true);
        $environment->expects($this->at(1))->method('get')->with($setting)->willReturn($value);

        $settings = new $class($environment, $policy);

        $this->assertSame($result, $settings->$property);
    }

    /**
     * Test unknown setting
     */
    public function testUnknownSetting()
    {
        $policy = $this->policy();
        $policy->expects($this->at(0))->method('setting')->with('', 'unknown')->willReturn('UNKNOWN');

        $environment = $this->environment();
        $environment->expects($this->at(0))->method('has')->with('UNKNOWN')->willReturn(false);
        $environment->expects($this->never())->method('get');

        $settings = new Stub\Unknown($environment, $policy);

        $this->assertNull($settings->unknown);
    }

    /**
     * Test skip static setting
     */
    public function testSkipStaticSetting()
    {
        $policy = $this->policy();
        $policy->expects($this->never())->method('setting');

        $environment = $this->environment();
        $environment->expects($this->never())->method('has');
        $environment->expects($this->never())->method('get');

        new Stub\SkipStatic($environment, $policy);

        $this->addToAssertionCount(1);
    }
}
