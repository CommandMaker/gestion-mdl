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

import React from 'react';
import { ColumnDefinition, TableDataType } from '~/types/htmlTableTypes';
import { v4 as uuid } from 'uuid';
import { getNestedProp } from '~/utils/objects';

import Styles from './SortableTableBody.module.scss';

type SortableTableBodyProps = {
    gridTemplate: string;
    rows: Record<string, TableDataType>[];
    stripped: boolean;
    columns: ColumnDefinition[];
};

export const SortableTableBody = ({
    rows,
    stripped,
    gridTemplate,
    columns
}: SortableTableBodyProps): React.ReactElement => {
    return (
        <tbody>
            {rows.map((r, i) => (
                <tr
                    key={uuid()}
                    style={{
                        display: 'grid',
                        gridTemplateColumns: gridTemplate
                    }}
                    className={`${Styles.SortableTableBodyRow} ${stripped && i % 2 === 0 ? Styles.stripped : ''}`}
                >
                    {columns.map(c => (
                        <td key={uuid()}>
                            {c.renderElement !== undefined
                                ? c.renderElement(r)
                                : (getNestedProp(r, c.key) as
                                      | string
                                      | boolean
                                      | number)}
                        </td>
                    ))}
                </tr>
            ))}
        </tbody>
    );
};
