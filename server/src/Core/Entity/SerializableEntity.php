<?php

namespace App\Core\Entity;

trait SerializableEntity
{
    /**
     * Return the entity serialized to JSON
     * If no props are specified, it will use the $serializable property of the entity class
     *
     * @param  string[]|null  $props  The props to serialize
     */
    public function toJson(?array $props = null): string|false
    {
        return json_encode($this->toArray($props));
    }

    /**
     * Return the specified props in an array style.
     * If no props are specified, it will use the $serializable property of the entity class
     *
     * @param  string[]|null  $props  The props to serialize
     * @return string[] The serialized array
     */
    public function toArray(?array $props = null): array
    {
        if ($props !== null) {
            $serialized = [];

            foreach ($props as $prop) {
                $methodName = 'get' . ucfirst(str_replace(' ', '', $prop));

                if (method_exists($this, $methodName)) {
                    $serialized[$prop] = $this->$methodName();
                }
            }

            return $serialized;
        }

        if (property_exists(self::class, 'serializable')) {
            $serialized = [];
            foreach ($this->serializable as $prop) {
                $methodName = 'get' . ucfirst(str_replace(' ', '', $prop));

                if (method_exists($this, $methodName)) {
                    $serialized[$prop] = $this->$methodName();
                }
            }

            return $serialized;
        }

        return [];
    }
}
