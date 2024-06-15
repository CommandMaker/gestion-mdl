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
