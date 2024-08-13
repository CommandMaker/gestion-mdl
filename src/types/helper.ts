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

/**
 * Type used to override props from a type
 *
 * Got from https://medium.com/@ofirstiberdev/overriding-type-properties-in-typescript-like-a-pro-54203a817253
 */
type Override<
    Type,
    NewType extends { [key in keyof Type]?: NewType[key] }
> = Omit<Type, keyof NewType> & NewType;
