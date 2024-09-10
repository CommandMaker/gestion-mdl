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

import { Input } from 'antd';
import React, { useCallback, useEffect, useState } from 'react';
import { getHistory, get_all_time_periods } from '~/api';
import { post_scan_card } from '~/api/requests/post_scan_card';
import { CardScan, TimePeriod } from '~/types/server/entities';
import { UserSubscriptionTag } from '~/ui/Atoms';
import { HourSelector, SortableTable } from '~/ui/Organisms';

export const ScanPage = (): React.ReactElement => {
    const [hours, setHours] = useState<TimePeriod[]>();
    const [selectedHour, setSelectedHour] = useState<string>();
    const [history, setHistory] = useState<CardScan[]>();
    const [isLoaded, setLoaded] = useState<boolean>(false);
    const [code, setCode] = useState<string>('');

    /**
     * Fetch time periods when the page is loaded
     */
    useEffect(() => {
        get_all_time_periods().then(t => {
            if (t.length === 0) return;

            setHours(t);
            setSelectedHour(t[0]['@id']);
        });
    }, []);

    /**
     * Refetch the history when time period is changed
     */
    useEffect(() => {
        if (selectedHour === undefined) return;

        getHistory({ timePeriodId: selectedHour, date: new Date() }).then(h => {
            setHistory(h);
            setLoaded(true);
        });
    }, [selectedHour]);

    /**
     * Function triggered when the user change the selected hour in the selector
     */
    const onHourSelectorChange = useCallback(
        (e: React.ChangeEvent<HTMLInputElement>) =>
            setSelectedHour(e.target.value),
        []
    );

    const scanCard = useCallback(
        (e: React.FormEvent<HTMLFormElement>) => {
            e.preventDefault();
            e.stopPropagation();
            post_scan_card(code, selectedHour || '').then(d => {
                setHistory(s => [...(s || []), d]);
            });
        },
        [code, selectedHour]
    );

    return isLoaded ? (
        <main>
            <h1>Entrées du foyer</h1>

            <HourSelector
                name="hours"
                data={hours || []}
                onChange={onHourSelectorChange}
            />

            <div style={{ width: '100%', margin: '1rem 0' }} aria-hidden />

            <form action="#" onSubmit={scanCard}>
                <Input
                    id="card_scan"
                    placeholder="Scanner une carte"
                    autoFocus
                    value={code}
                    onChange={e => setCode(e.target.value)}
                />
            </form>

            <SortableTable
                data={history || []}
                stripped
                columns={[
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
    ) : (
        <p>Chargement</p>
    );
};
