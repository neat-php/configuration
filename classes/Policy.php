<?php

namespace Neat\Configuration;

class Policy
{
    /**
     * Get setting name for property
     *
     * @param string $prefix
     * @param string $property
     * @return string
     */
    public function setting(string $prefix, string $property): string
    {
        return strtoupper($prefix . preg_replace('/(?<!^)[A-Z]/', '_$0', $property));
    }
}
