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

class AbstractEntity
{
    use EntityMapper;

    /**
     * @var array<string, mixed|AbstractEntity>
     */
    protected array $relations = [];

    protected function getGetterForProperty(string $property): string
    {
        return 'get' . ucfirst(str_replace(' ', '', $property));
    }

    protected function getSetterForProperty(string $property): string
    {
        return 'set' . ucfirst(str_replace(' ', '', $property));
    }
}
