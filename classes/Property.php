<?php

/** @noinspection PhpDocMissingThrowsInspection */

namespace Neat\Configuration;

use DateTime;
use DateTimeImmutable;
use ReflectionProperty;

class Property
{
    /**
     * @var ReflectionProperty
     */
    protected $reflection;

    /**
     * @var string
     */
    protected $type;

    /**
     * Property constructor
     *
     * @param ReflectionProperty $reflection
     * @note Activates the reflection's accessible flag
     */
    public function __construct(ReflectionProperty $reflection)
    {
        $reflection->setAccessible(true);

        $this->reflection = $reflection;

        if (preg_match('/\\s@var\\s([\\w\\\\]+)(?:\\|null)?\\s/', $reflection->getDocComment(), $matches)) {
            $this->type = strtr(ltrim($matches[1], '\\'), [
                'integer' => 'int',
                'boolean' => 'bool',
            ]);
        }
    }

    /**
     * Set value
     *
     * @param object $object
     * @param mixed  $value
     */
    public function set($object, $value)
    {
        if ($value !== null) {
            switch ($this->type) {
                case 'bool':
                case 'int':
                    settype($value, $this->type);
                    break;
                case 'DateTime':
                    $value = new DateTime($value);
                    break;
                case 'DateTimeImmutable':
                    $value = new DateTimeImmutable($value);
                    break;
            }
        }

        $this->reflection->setValue($object, $value);
    }
}
