<?php

namespace Neat\Configuration\Test\Stub;

use Neat\Configuration\Settings;

class Boolean
{
    use Settings;

    const PREFIX = 'TEST_';

    /** @var bool */
    public $boolean;
}
