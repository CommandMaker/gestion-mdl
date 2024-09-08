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
import { DatePicker, Input, type DatePickerProps } from 'antd';
import { HourSelector, SortableTable } from '~/ui/Organisms';
import { CardScan, TimePeriod } from '~/types/server/entities';
import { getHistory, get_all_time_periods } from '~/api';
import { UserSubscriptionTag } from '~/ui/Atoms';
import { GetHistoryRequest } from '~/types/server/requests';

export const HistoryPage = (): React.ReactElement => {
    const [requestData, setRequestData] = useState<GetHistoryRequest>({
        timePeriodId: '',
    });
    const [timePeriods, setTimePeriods] = useState<TimePeriod[]>([]);
    const [history, setHistory] = useState<CardScan[]>([]);
    const [filteredHistory, setFilteredHistory] = useState<CardScan[]>([]);

    /**
     * Fetch the time periods when page is loaded
     */
    useEffect(() => {
        get_all_time_periods().then(d => {
            setTimePeriods(d);

            d.length > 0
                ? setRequestData(s => ({ ...s, timePeriodId: d[0]['@id'] }))
                : undefined;
        });
    }, []);

    useEffect(() => {
        setFilteredHistory(history);
    }, [history]);

    /**
     * Fetch the history if all data are filled
     */
    useEffect(() => {
        if (requestData.date === undefined || requestData.timePeriodId === '')
            return;

        getHistory(requestData).then(d => setHistory(d));
    }, [requestData]);

    const onChange: DatePickerProps['onChange'] = (_, dateString) => {
        setRequestData(s => ({ ...s, date: new Date(dateString as string) }));
    };

    return (
        <main>
            <h1>Historique du foyer</h1>

            <p style={{ marginBottom: '1rem' }}>Sélectionnez une date :</p>
            <DatePicker onChange={onChange} style={{ width: '100%' }} />

            <p style={{ margin: '1rem 0' }}>Puis une plage horaire :</p>
            <HourSelector
                name="hours"
                data={timePeriods}
                onChange={e =>
                    setRequestData(s => ({
                        ...s,
                        timePeriodId: e.target.value
                    }))
                }
            />

            <div style={{ height: 0, margin: '2rem 0' }} />

            <Input
                type="text"
                size="large"
                placeholder="Rechercher dans l'historique"
                onChange={e => {
                    if (e.target.value === '') {
                        setFilteredHistory(history);
                        return;
                    }

                    const search = e.target.value.toLocaleLowerCase();
                    console.log(search);
                    setFilteredHistory(
                        history.filter(
                            s =>
                                s.code.toLocaleLowerCase().includes(search) ||
                                s.user.firstname
                                    .toLocaleLowerCase()
                                    .includes(search) ||
                                s.user.lastname
                                    .toLocaleLowerCase()
                                    .includes(search)
                        )
                    );
                }}
            />

            <SortableTable
                stripped
                data={filteredHistory}
                columns={[
                    {
                        label: 'Code',
                        key: 'user.code',
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
