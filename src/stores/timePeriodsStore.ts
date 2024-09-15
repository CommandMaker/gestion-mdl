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
            }
        }),
        {
            name: 'time-periods-store',
            storage: createJSONStorage(() => sessionStorage)
        }
    )
);
