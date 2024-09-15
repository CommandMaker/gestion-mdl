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
import { createJSONStorage, persist } from 'zustand/middleware';
import { get_all_subscription_types } from '~/api';
import { SubscriptionType } from '~/types/server/entities';

type SubscriptionTypeStore = {
    subscriptionTypes?: SubscriptionType[];
    fetchData: () => Promise<void>;
};

export const useSubscriptionTypeStore = create<SubscriptionTypeStore>()(
    persist(
        (set, get) => ({
            subscriptionTypes: undefined,
            fetchData: async () => {
                if (get().subscriptionTypes !== undefined) return;

                const subscriptionTypes = await get_all_subscription_types();

                set({ subscriptionTypes });
            }
        }),
        {
            name: 'subscription-types-storage',
            storage: createJSONStorage(() => sessionStorage)
        }
    )
);
