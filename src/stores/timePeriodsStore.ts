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

import { create } from 'zustand';
import { persist, createJSONStorage } from 'zustand/middleware';
import { get_all_time_periods } from '~/api';
import { TimePeriod } from '~/types/server/entities';

type TimePeriodsStore = {
    timePeriods?: TimePeriod[];
    fetchData: () => Promise<TimePeriod[]>;
    getCurrentTimePeriod: () => string;
};

export const useTimePeriodsStore = create<TimePeriodsStore>()(
    persist(
        (set, get) => ({
            timePeriods: undefined,
            fetchData: async (): Promise<TimePeriod[]> => {
                if (get().timePeriods !== undefined) return get().timePeriods!;

                const timePeriods = await get_all_time_periods();

                set({ timePeriods: timePeriods });

                return timePeriods;
            },
            getCurrentTimePeriod: (): string => {
                const currentTime = new Date();
                const fDate = `${currentTime.getHours().toString().padStart(2, '0')}:${currentTime.getMinutes().toString().padStart(2, '0')}:${currentTime.getSeconds().toString().padStart(2, '0')}`;

                if (get().timePeriods !== undefined) {
                    for (const period of get().timePeriods!) {
                        if (
                            fDate >= period.startTime &&
                            fDate < period.endTime
                        ) {
                            return period['@id'];
                        }
                    }
                }

                return '/api/time_periods/1';
            }
        }),
        {
            name: 'time-periods-store',
            storage: createJSONStorage(() => sessionStorage)
        }
    )
);
