<?php

namespace Neat\Configuration\Test\Stub;

use Neat\Configuration\Settings;

class Name
{
    use Settings;

    const PREFIX = 'TEST_';

    /** @var string */
    public $name;
}
