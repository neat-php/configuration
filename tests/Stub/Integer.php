<?php

namespace Neat\Configuration\Test\Stub;

use Neat\Configuration\Settings;

class Integer
{
    use Settings;

    const PREFIX = 'TEST_';

    /** @var int */
    public $integer;
}
