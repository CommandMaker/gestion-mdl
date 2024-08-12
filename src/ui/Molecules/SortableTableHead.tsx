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

import React, { useState } from 'react';
import { ColumnDefinition } from '~/types/htmlTableTypes';
import { v4 as uuid } from 'uuid';
import { TableColumnHeadSortIcon } from '~/ui/Atoms/Table/TableColumnHeadSortIcon';
import Styles from './SortableTableHead.module.scss';

type SortableTableHeadProps = {
    columns: ColumnDefinition[];
    gridTemplate: string;
    onSortChange?: (
        column: ColumnDefinition,
        sortOrder: 'none' | 'asc' | 'desc'
    ) => void;
};

const sorts = ['none', 'asc', 'desc'];

export const SortableTableHead = ({
    columns,
    gridTemplate,
    onSortChange: sortCallback
}: SortableTableHeadProps): React.ReactElement => {
    const [sortOrder, setSortOrder] = useState<{
        id: number;
        col: ColumnDefinition;
    }>({ id: 0, col: { label: '', key: '' } });

    const onSortChange = (e: React.MouseEvent, column: ColumnDefinition) => {
        e.preventDefault();

        if (!column.sortable) return;

        let index = sortOrder.id;

        if (index + 1 > sorts.length - 1) {
            index = 0;
        } else {
            index += 1;
        }

        sortCallback
            ? sortCallback(column, sorts[index] as 'none' | 'asc' | 'desc')
            : undefined;
        setSortOrder({ id: index, col: column });
    };

    return (
        <thead className={Styles.SortableTableHead}>
            <tr
                style={{
                    display: 'grid',
                    gridTemplateColumns: gridTemplate,
                    padding: '1rem 0',
                    textAlign: 'left',
                    cursor: 'pointer'
                }}
            >
                {columns.map(c => (
                    <th
                        key={uuid()}
                        onClick={e => onSortChange(e, c)}
                        style={{ userSelect: 'none' }}
                    >
                        {c.label}
                        &nbsp; &nbsp;
                        {c.sortable ? (
                            <TableColumnHeadSortIcon
                                sortOrder={
                                    c === sortOrder.col
                                        ? (sorts[sortOrder.id] as
                                              | 'none'
                                              | 'asc'
                                              | 'desc')
                                        : 'none'
                                }
                            />
                        ) : undefined}
                    </th>
                ))}
            </tr>
        </thead>
    );
};
