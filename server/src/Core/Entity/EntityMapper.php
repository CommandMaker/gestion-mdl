<?php

namespace App\Core\Entity;

use ReflectionClass;

trait EntityMapper
{
    /**
     * Create an entity from the specified array
     *
     * @param  mixed[]  $data
     */
    public static function mapFromArray(array $data): self
    {
        $klass = new ReflectionClass(self::class);
        $entity = $klass->newInstance();

        /**
         * @var string $key
         * @var mixed $value
         */
        foreach ($data as $key => $value) {
            $funcName = 'set' . ucfirst(str_replace(' ', '', $key));

            if ($klass->hasMethod($funcName)) {
                $entity->$funcName($value);
            }
        }

        return $entity;
    }
}
