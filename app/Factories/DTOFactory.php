<?php

namespace App\Factories;

use Illuminate\Http\Request;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

abstract class DTOFactory
{
    const MODEL = null;

    /**
     * @throws ReflectionException
     */
    public static function fromRequest(Request $request)
    {
        return static::fromArray($request->validated());
    }

    /**
     * @throws ReflectionException
     */
    public static function fromArray(array $data)
    {
        $reflection = new ReflectionClass(static::MODEL);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
        $DTOProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->name;
            $defaultValue = $property->getDefaultValue();
            $isNullable = $property->getType()->allowsNull();
            if (!array_key_exists($propertyName, $data)) {
                if (!$isNullable && $defaultValue === null) {
                    throw new ReflectionException("Missing property '$propertyName' in input array.");
                }
                $DTOProperties[$propertyName] = $defaultValue;
            } else {
                $DTOProperties[$propertyName] = $data[$propertyName];
            }
        }
        return new (static::MODEL)(...$DTOProperties);
    }

}
