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
        $class  = new ReflectionClass($this);
        $prefix = $class->getConstant('PREFIX') ?: '';
        foreach ($class->getProperties() as $reflectionProperty) {
            if ($reflectionProperty->isStatic()) {
                continue;
            }

            $setting = $policy->setting($prefix, $reflectionProperty->getName());
            if ($environment->has($setting)) {
                $property = new Property($reflectionProperty);
                $property->set($this, $environment->get($setting));
            }
        }
    }
}
