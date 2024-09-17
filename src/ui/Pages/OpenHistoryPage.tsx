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

import React, { useEffect, useState } from 'react';
import { get_all_open_history } from '~/api';
import { FoyerOpenHistory } from '~/types/server/entities';
import { SortableTable } from '../Organisms';

export const OpenHistoryPage = (): React.ReactElement => {
    const [history, setHistory] = useState<FoyerOpenHistory[]>();

    useEffect(() => {
        get_all_open_history().then(d => setHistory(d));
    }, []);

    return <main>
        <h1>Historique des ouvertures</h1>

        {history ?
            <SortableTable
                data={history!}
                columns={[
                    {
                        label: 'Date',
                        key: 'date',
                        renderElement: (row: FoyerOpenHistory): React.ReactElement => {
                            const date = new Date(row.date);

                            return <p>{date.getDate().toString().padStart(2, '0')}/{date.getMonth().toString().padStart(2, '0')}/{date.getFullYear()} à {date.getHours().toString().padStart(2, '0')}:{date.getMinutes().toString().padStart(2, '0')}</p>
                        },
                        sortable: true
                    },
                    {
                        label: 'Gérant',
                        key: 'user.firstname',
                        renderElement: (row: FoyerOpenHistory) => <p>{row.user.firstname} {row.user.lastname}</p>
                    }
                ]}
            />
            :
            <p>Chargement ...</p>
        }
    </main>
}
