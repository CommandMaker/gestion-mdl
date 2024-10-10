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
import { useNavigate } from 'react-router-dom';
import { getHistory } from '~/api';
import { useTimePeriodsStore, useUserStore } from '~/stores';
import { CardScan } from '~/types/server/entities';
import { UserSubscriptionTag } from '~/ui/Atoms';
import { HourSelector, SortableTable } from '~/ui/Organisms';
import { omit } from '~/utils';

export const ScanPage = (): React.ReactElement => {
    const [selectedHour, setSelectedHour] = useState<string>();
    const [history, setHistory] = useState<CardScan[]>([]);
    const [isLoaded, setLoaded] = useState<boolean>(false);
    const [isSocketOpened, setSocketOpened] = useState<boolean>(false);
    const timePeriodsStore = useTimePeriodsStore();
    const userStore = useUserStore();
    const navigate = useNavigate();

    /**
     * Fetch time periods when the page is loaded
     */
    useEffect(() => {
        timePeriodsStore.fetchData().then(tps => {
            const timePeriod = timePeriodsStore.getCurrentTimePeriod();
            setSelectedHour(timePeriod);
        });

        const socket = new WebSocket('ws://localhost:8080');

        socket.addEventListener('open', () => setSocketOpened(true));
        socket.addEventListener('close', () => setSocketOpened(false));

        socket.addEventListener('message', data => {
            const parsedData = omit(JSON.parse(data.data), [
                '@context'
            ]) as CardScan;
            setHistory(s => [...s, parsedData]);
        });

        return () => {
            socket.close();
        };
    }, []);

    useEffect(() => {
        let cId;

        const callback = () => {
            const timePeriod = timePeriodsStore.getCurrentTimePeriod();

            if (timePeriod !== selectedHour && selectedHour !== undefined) {
                console.log(selectedHour);
                userStore.logout().then(_ => navigate('/login'));
            }

            setSelectedHour(timePeriod);
        };

        let a = setTimeout(
            () => {
                callback();
                cId = setInterval(() => callback(), 60 * 1000);
            },
            (60 - new Date().getSeconds()) * 1000
        );

        return () => {
            if (a) clearTimeout(a);

            if (cId) {
                clearInterval(cId);
                cId = undefined;
            }
        };
    }, [selectedHour]);

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

    return isLoaded ? (
        <main>
            <div
                style={{
                    width: '100%',
                    display: 'flex',
                    justifyContent: 'space-between',
                    alignItems: 'center'
                }}
            >
                <h1>Entrées du foyer</h1>
                <p>
                    État du service de scan :{' '}
                    <strong>
                        {isSocketOpened ? 'Fonctionel' : 'Déconnecté'}
                    </strong>
                </p>
            </div>

            <HourSelector
                name="hours"
                data={timePeriodsStore.timePeriods || []}
                onChange={onHourSelectorChange}
                value={selectedHour}
            />

            <div style={{ width: '100%', margin: '1rem 0' }} aria-hidden />

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
