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

import { API_URL } from '~/types/constants';
import { User } from '~/types/server/entities';

/**
 * Delete a user from the app
 *
 * @param {User} user The user to delete
 * @return {BaseResponse} The response of the server
 */
export const delete_user = async (user: User): Promise<void> => {
    const req = await fetch(`${API_URL}${user['@id']}`, {
        method: 'DELETE',
        credentials: 'include'
    });

    if (!req.ok) {
        throw new Error(req.statusText);
    }
};
