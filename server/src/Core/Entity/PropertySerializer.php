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

use App\Core\Entity\Exceptions\SerializableException;
use App\Core\Entity\Serializers\DateTimeSerializer;

class PropertySerializer
{
    /**
     * @var array<string, class-string>
     */
    private array $castsMap = [
        'datetime' => DateTimeSerializer::class,
    ];

    /**
     * @return string|bool|int|array<string, mixed>|null
     */
    public function serialize(mixed $prop, ?string $cast = null): string|bool|int|float|array|null
    {
        if (in_array(gettype($prop), ['string', 'boolean', 'integer', 'float', 'NULL', 'double'])) {
            /** @var string|bool|int|float|null */
            return $prop;
        }

        if ($cast !== null) {
            $valCast = explode(':', $cast, 2);

            if (!in_array($valCast[0], array_keys($this->castsMap))) {
                throw new SerializableException("The cast type \"$valCast[0]\" is not a castable type");
            }

            $klass = $this->castsMap[$valCast[0]];
            if (is_callable(new $klass)) {
                /** @return string|bool|int|array<string, mixed>|null */
                return (new $klass)($prop, count($valCast) > 1 ? $valCast[1] : null);
            }
        }

        if (gettype($prop) === 'object') {
            return $this->serializeObject($prop);
        }

        if (gettype($prop) === 'array') {
            return $this->serializeArray($prop);
        }

        return null;
    }

    /**
     * @return array<string, mixed>
     */
    public function serializeObject(object $obj): array
    {
        if (method_exists($obj, 'toArray')) {
            return $obj->toArray();
        }

        return (array) $obj;
    }

    /**
     * @param  mixed[]  $array
     * @return array<string, mixed>
     */
    public function serializeArray(array $array): array
    {
        $serialized = [];

        foreach ($array as $key => $value) {
            $serialized[$key] = $this->serialize($value);
        }

        return $serialized;
    }
}
