<?php

namespace Neat\Configuration\Test;

use Neat\Configuration\Environment;
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    /**
     * Test empty config
     */
    public function testEmpty()
    {
        $config = new Environment;

        $this->assertFalse($config->has('x'));
        $this->assertNull($config->get('x'));
        $this->assertSame([], $config->all());
        $this->assertSame([], $config->query('x'));
    }

    /**
     * Test loaded config
     */
    public function testLoaded()
    {
        $config = new Environment($data = [
            'system_name'    => 'App',
            'app_email'      => 'app@example.com',
            'app_url'        => 'https://app.example.com/',
        ]);

        $this->assertSame($data, $config->all());
        $this->assertSame($data['system_name'], $config->get('system_name'));
        $this->assertTrue($config->has('system_name'));
        $this->assertSame(['app_email' => $data['app_email'], 'app_url' => $data['app_url']], $config->query('app_'));
    }
}
