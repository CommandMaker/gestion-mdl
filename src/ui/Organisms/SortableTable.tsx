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

import { useEffect, useState } from 'react';
import { TableDataType, ColumnDefinition } from '~/types/htmlTableTypes';
import { SortableTableBody } from '~/ui/Molecules/SortableTableBody';
import { SortableTableHead } from '~/ui/Molecules/SortableTableHead';
import Styles from '~/ui/Organisms/SortableTable.module.scss';
import { getNestedProp } from '~/utils/objects';
import { getGridColumnTemplate } from '~/utils/tables';

// Props definition
type SortableTableProps = {
    data: Record<string, TableDataType>[];
    columns: ColumnDefinition[];
    stripped?: boolean;
};

export const SortableTable = ({
    data,
    columns,
    stripped = false
}: SortableTableProps): React.ReactElement => {
    const gridTemplate = getGridColumnTemplate(columns);
    const [rows, setRows] = useState<Record<string, TableDataType>[]>(data);

    useEffect(() => {
        setRows(data);
    }, [data]);

    /**
     * Handle the column sorting
     *
     * @param {ColumnDefinition} column The column which the data will be sorted by
     * @param {'none' | 'asc' | 'desc'} sortOrder The order to sort the column by
     */
    const onSortChange = (
        column: ColumnDefinition,
        sortOrder: 'none' | 'asc' | 'desc'
    ): void => {
        if (sortOrder === 'none') {
            setRows(data);
            return;
        }

        setRows(
            rows.concat().sort((a, b) => {
                const aVal = getNestedProp(a, column.key);
                const bVal = getNestedProp(b, column.key);

                // Use a user-defined function if available (used to perform a custom sort)
                if (column.sortFunction !== undefined)
                    return sortOrder === 'asc'
                        ? column.sortFunction(aVal, bVal)
                        : sortOrder === 'desc'
                          ? -column.sortFunction(aVal, bVal)
                          : 0;

                if (sortOrder === 'asc')
                    return `${aVal}`.localeCompare(`${bVal}`);
                else if (sortOrder === 'desc')
                    return `${bVal}`.localeCompare(`${aVal}`);

                return 0;
            })
        );
    };

    return (
        <table className={Styles.SortableTable}>
            <SortableTableHead
                columns={columns}
                gridTemplate={gridTemplate}
                onSortChange={onSortChange}
            />
            <SortableTableBody
                rows={rows}
                stripped={stripped}
                gridTemplate={gridTemplate}
                columns={columns}
            />
        </table>
    );
};
