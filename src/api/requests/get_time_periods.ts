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
import { TimePeriod } from '~/types/server/entities';
import { BaseResponse } from '~/types/server/response';

export const getTimePeriods = async (): Promise<TimePeriod[]> => {
    const req = await fetch(`${API_URL}/api/time-periods/all`);
    const data: BaseResponse<TimePeriod[]> = await req.json();

    if (req.status !== 200)
        throw new Error(req.statusText + ' : ' + data.message);

    return data.data || [];
};
