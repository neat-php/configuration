<?php

namespace Neat\Configuration\Test;

use Neat\Configuration\Policy;
use PHPUnit\Framework\TestCase;

class PolicyTest extends TestCase
{
    /**
     * Test policy setting
     */
    public function testSetting()
    {
        $policy = new Policy();

        $this->assertSame('', $policy->setting('', ''));
        $this->assertSame('PREFIX_', $policy->setting('PREFIX_', ''));
        $this->assertSame('PREFIX_', $policy->setting('prefix_', ''));
        $this->assertSame('SETTING', $policy->setting('', 'setting'));
        $this->assertSame('CAMEL_CASED', $policy->setting('', 'camelCased'));
        $this->assertSame('PREFIXED_CAMEL_CASED', $policy->setting('prefixed_', 'camelCased'));
    }
}
