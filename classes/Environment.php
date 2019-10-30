<?php

namespace Neat\Configuration;

class Environment
{
    /** @var string[] */
    protected $settings;

    /**
     * Config constructor
     *
     * @param string[] $settings
     */
    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
    }

    /**
     * Get all settings
     *
     * @return string[]
     */
    public function all(): array
    {
        return $this->settings;
    }

    /**
     * Has setting?
     *
     * @param string $var
     * @return bool
     */
    public function has(string $var): bool
    {
        return isset($this->settings[$var]);
    }

    /**
     * Get setting
     *
     * @param string $var
     * @return string|null
     */
    public function get(string $var)
    {
        return $this->settings[$var] ?? null;
    }

    /**
     * Get settings beginning with prefix
     *
     * @param string $prefix
     * @return array
     */
    public function query(string $prefix): array
    {
        $settings = [];
        foreach ($this->settings as $var => $val) {
            if (strpos($var, $prefix) === 0) {
                $settings[substr($var, strlen($prefix))] = $val;
            }
        }

        return $settings;
    }
}
