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

export type TableDataType = string | number | boolean | object;

/**
 * Represent a table column
 */
export type ColumnDefinition = {
    /**
     * The label to display in the column head
     */
    label: string;
    /**
     * The key to search the data in the data object.
     * Can be a nested key (ex: `user.id`)
     */
    key: string;
    /**
     * Define if the column is sortable
     * Default value : `false`
     */
    sortable?: boolean;
    /**
     * Define the width of the column
     * Default value : `1fr`
     */
    width?: string;
    /**
     * If the column is sortable, use this function to perform a custom sort action
     */
    sortFunction?: (
        a: TableDataType | undefined,
        b: TableDataType | undefined
    ) => number;
    /**
     * Used to return a custom display for this column
     */
    renderElement?: (row: any) => React.ReactElement;
};
