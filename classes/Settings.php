<?php

namespace Neat\Configuration;

use Neat\Object\Property;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

trait Settings
{
    /**
     * Settings constructor
     *
     * @param Environment $environment
     * @param Policy      $policy
     * @throws ReflectionException
     */
    public function __construct(Environment $environment, Policy $policy)
    {
        $class    = new ReflectionClass($this);
        $prefix   = $class->getConstant('PREFIX') ?: '';
        $settings = $environment->query($prefix);

        foreach ($class->getProperties() as $reflectionProperty) {
            if ($reflectionProperty->isStatic()) {
                continue;
            }

            $setting = $policy->setting($reflectionProperty->getName());
            if (isset($settings[$setting])) {
                $property = $this->property($reflectionProperty);
                $property->set($this, $settings[$setting]);
            }
        }
    }

    /**
     * @param ReflectionProperty $reflection
     * @return Property|Property\Boolean|Property\DateTime|Property\DateTimeImmutable|Property\Integer
     */
    private function property(ReflectionProperty $reflection): Property
    {
        if (preg_match('/\\s@var\\s([\\w\\\\]+)(?:\\|null)?\\s/', $reflection->getDocComment(), $matches)) {
            $type = ltrim($matches[1], '\\');
            switch ($type) {
                case 'bool':
                case 'boolean':
                    return new Property\Boolean($reflection);
                case 'int':
                case 'integer':
                    return new Property\Integer($reflection);
                case 'DateTime':
                    return new Property\DateTime($reflection);
                case 'DateTimeImmutable':
                    return new Property\DateTimeImmutable($reflection);
            }
        }

        return new Property($reflection);
    }
}
