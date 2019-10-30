<?php

namespace Neat\Configuration;

use Neat\Object\Property;
use ReflectionClass;
use ReflectionException;

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
                $property = new Property($reflectionProperty);
                $property->set($this, $settings[$setting]);
            }
        }
    }
}
