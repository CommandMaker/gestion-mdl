<?php

/*
 *  Copyright (C) 2024 Command_maker
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace App\Core\Entity;

use App\Bootstrap;

trait SerializableEntity
{
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
        $properties = $merge ? array_merge($this->serializable, $props !== null ? $props : []) : ($props !== null ? $props : $this->serializable);
        /** @var PropertySerializer */
        $serializer = Bootstrap::getContainerService(PropertySerializer::class);

        return array_combine($properties, array_map(
            fn ($prop) => $serializer->serialize($this->getValueForProperty($prop), $this->getCastForProperty($prop)),
            $properties
        ));
    }

    /**
     * @return mixed[]
     */
    private function getValueForProperty(string $property): mixed
    {
        $getter = $this->getGetterForProperty($property);

        return $this->$getter();
    }

    /**
     * @return ?string
     */
    private function getCastForProperty(string $property): ?string
    {
        $casts = $this->cast();

        return in_array($property, array_keys($casts)) ? $casts[$property] : null;
    }
}
