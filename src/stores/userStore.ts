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
import { get_logout, get_user, post_login_user } from '~/api';
import { User } from '~/types/server/entities';

type LoginData = {
    username: string;
    password: string;
};

type UserStore = {
    user?: User;
    login: (loginData: LoginData) => Promise<void>;
    logout: () => Promise<void>;
};

export const useUserStore = create<UserStore>()(
    persist(
        set => ({
            user: undefined,
            login: async (loginData: LoginData): Promise<void> => {
                await post_login_user(loginData);
                const user = await get_user();

                set({ user });
            },
            logout: async (): Promise<void> => {
                await get_logout();

                sessionStorage.clear();
            }
        }),
        {
            name: 'user-store',
            storage: createJSONStorage(() => sessionStorage)
        }
    )
);
