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

import React, { useCallback, useEffect, useState } from 'react';
import { API_URL } from '~/types/constants';
import { CardScan, TimePeriod } from '~/types/server';
import { UserSubscriptionTag } from '~/ui/Atoms';
import { HourSelector, SortableTable } from '~/ui/Organisms';

export const ScanPage = (): React.ReactElement => {
    const [hours, setHours] = useState<TimePeriod[]>([]);
    const [selectedHour, setSelectedHour] = useState<number>();
    const [history, setHistory] = useState<CardScan[]>([]);

    useEffect(() => {
        (async () => {
            const req = await fetch(`${API_URL}/api/time-periods/all`);

            if (req.status !== 200) throw new Error(req.statusText);

            const data = await req.json();

            setHours(data.data);
            setSelectedHour(data.data[0].id);
        })();
    }, []);

    /**
     * Refetch the history when time period is edited
     */
    useEffect(() => {
        if (selectedHour === 0 || selectedHour === undefined) return;

        (async () => {
            const reqData = new FormData();
            const date = new Date();
            reqData.append('timePeriodId', selectedHour.toString());
            reqData.append('date', `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')}`);

            const historyReq = await fetch(`${API_URL}/api/scans/get`, {
                method: 'POST',
                headers: {
                    Accept: 'application/json'
                },
                body: reqData
            });

            const data = await historyReq.json();

            if (data.status !== 'ok') throw new Error(historyReq.statusText);

            setHistory(data.data);
        })();
    }, [selectedHour]);

    /**
     * Function triggered when the user change the selected hour in the selector
     */
    const onHourSelectorChange = useCallback((e: React.ChangeEvent<HTMLInputElement>) => setSelectedHour(+e.target.value), []);

    return (
        <main>
            <h1>Entrées du foyer</h1>

            <HourSelector
                name="hours"
                data={hours}
                onChange={onHourSelectorChange}
            />

            <div style={{width: '100%', margin: '1rem 0'}} aria-hidden />

            <SortableTable
                data={history}
                stripped
                columns={[
                    {
                        label: 'Code',
                        key: 'code',
                        sortable: true,
                        sortFunction: (a, b) =>
                            +((a as string).match(/\d+/) || 0) <
                                +((b as string).match(/\d+/) || 0)
                                ? -1
                                : 1,
                        width: '150px'
                    },
                    {
                        label: 'Nom',
                        key: 'user.lastname',
                        sortable: true
                    },
                    {
                        label: 'Prénom',
                        key: 'user.firstname',
                        sortable: true
                    },
                    {
                        label: 'Classe',
                        key: 'user.grade'
                    },
                    {
                        label: 'Abonnement',
                        key: 'user.subscriptionType.displayName',
                        width: '150px',
                        renderElement: (row: CardScan) => (
                            <UserSubscriptionTag user={row.user} />
                        )
                    }
                ]}
            />
        </main>
    );
};
