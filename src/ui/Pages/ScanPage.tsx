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
import { HourSelector } from '../Organisms/HourSelector';
import { TimePeriod } from '../../types/server/time_period';
import { API_URL } from '../../types/constants';

export const ScanPage = (): React.ReactElement => {
    const [hours, setHours] = useState<TimePeriod[]>([]);
    const [selectedHour, setSelectedHour] = useState<number>();

    useEffect(() => {
        (async () => {
            const req = await fetch(`${API_URL}/api/time-periods/all`);

            if (req.status !== 200) throw new Error(req.statusText);

            const data = await req.json();

            setHours(data.data);
            setSelectedHour(data.data[0].id);
        })();
    }, []);

    return (
        <main>
            <h1>Entrées du foyer</h1>

            <HourSelector
                name="hours"
                data={hours}
                onChange={e => setSelectedHour(+e.target.value)}
            />
        </main>
    );
};
