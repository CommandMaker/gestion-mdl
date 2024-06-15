<?php

namespace App\Core\Entity;

trait SerializableEntity
{
    /**
     * Return the entity serialized to JSON
     * If no props are specified, it will use the $serializable property of the entity class
     *
     * @param  bool|null  $merge  If the prop array is merged with the serializable attribute in class
     * @param  string[]|null  $props  The props to serialize
     */
    public function toJson(?array $props = null, ?bool $merge = false): string|false
    {
        return json_encode($this->toArray($props, $merge));
    }

    /**
     * Return the specified props in an array style.
     * If no props are specified, it will use the $serializable property of the entity class
     *
     * @param  string[]|null  $props  The props to serialize
     * @param bool|null $merge If the prop array is merged with the serializable attribute in class

     * @return array<string, mixed> The serialized array
     */
    public function toArray(?array $props = null, ?bool $merge = false): array
    {
        if ($props !== null && !$merge) {
            $serialized = [];

            foreach ($props as $prop) {
                $methodName = 'get' . ucfirst(str_replace(' ', '', $prop));
                $methodNameSerialized = $methodName . 'Serialized';

                if (method_exists($this, $methodNameSerialized) && (isset($this->$prop) || isset($this->relations[$prop . 'Relation']))) {
                    $serialized[$prop] = $this->$methodNameSerialized();

                    continue;
                }

                if (method_exists($this, $methodName) && (isset($this->$prop) || isset($this->relations[$prop . 'Relation']))) {
                    $serialized[$prop] = $this->$methodName();
                }
            }

            return $serialized;
        }

        if (property_exists(self::class, 'serializable')) {
            $serialized = [];

            $propsToSerialize = $merge ? array_merge($this->serializable, $props ?: []) : $this->serializable;

            foreach ($propsToSerialize as $prop) {
                $methodName = 'get' . ucfirst(str_replace(' ', '', $prop));
                $methodNameSerialized = $methodName . 'Serialized';

                if (method_exists($this, $methodNameSerialized)) {
                    $serialized[$prop] = $this->$methodNameSerialized();

                    continue;
                }

                if (method_exists($this, $methodName)) {
                    $serializedProp = $this->$methodName();
                    if (gettype($serializedProp) === 'object' && method_exists($serializedProp, 'toArray')) {
                        $serialized[$prop] = $serializedProp->toArray();
                    } else {
                        $serialized[$prop] = $serializedProp;
                    }
                }
            }

            return $serialized;
        }

        return [];
    }
}
