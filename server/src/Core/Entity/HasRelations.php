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
use Exception;
use PDO;
use ReflectionClass;

trait HasRelations
{
    /**
     * @param  class-string<AbstractEntity>  $entityClass
     */
    protected function hasOne(string $entityClass, string $localKey, string $foreignKey = 'id'): AbstractEntity
    {
        $relationKey = $localKey . 'Relation';
        if (isset($this->relations[$relationKey])) {
            /** @var AbstractEntity */
            return $this->relations[$relationKey];
        }

        /** @var PDO $pdo */
        $pdo = Bootstrap::getContainerService(PDO::class);
        $tableName = $entityClass::$tableName;
        $getter = $this->getGetterForProperty($localKey);
        $d = $this->$getter();
        $q = $pdo->prepare("SELECT * FROM $tableName WHERE $foreignKey = '$d'");
        $q->execute();
        /** @var array<string, mixed> $result */
        $result = $q->fetch();

        $reflection = new ReflectionClass($entityClass);
        if (!$reflection->hasMethod('mapFromArray')) {
            throw new Exception('The target entity must have the "EntityMapper" trait.');
        }

        $this->relations[$relationKey] = $entityClass::mapFromArray($result);

        /** @var AbstractEntity */
        return $this->relations[$relationKey];
    }
}
