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

export const getNestedProp = (
    obj: { [key: string]: string | number | boolean | object },
    key: string
): string | number | boolean | object | undefined => {
    const keys = key.split('.');

    for (const k of keys) {
        if (keys.indexOf(k) !== keys.length - 1) {
            return getNestedProp(
                obj[k] as { [key: string]: string | number | boolean | object },
                keys.slice(keys.indexOf(k) + 1).join('.')
            );
        } else {
            return obj[k];
        }
    }
};

/**
 * Return the object with properties omitted
 * Return type is the object with properties omitted
 *
 * @return {object}
 */
export const omit = <T extends {[key: string]: any}, K extends (keyof T)[]>(obj: T, properties: K): Omit<T, K[number]> => {
    const a = structuredClone(obj);
    properties.forEach(key => Reflect.deleteProperty(a, key));

    return a;
}
