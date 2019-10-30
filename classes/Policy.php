<?php

namespace Neat\Configuration;

class Policy
{
    /**
     * Get setting name for property
     *
     * @param string $property
     * @return string
     */
    public function setting(string $property): string
    {
        return strtoupper(preg_replace('/(?<!^)[A-Z]/', '_$0', $property));
    }
}
