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
import { CardScan } from '~/types/server/entities';
import { GetHistoryRequest } from '~/types/server/requests';

export const getHistory = async (
    req: GetHistoryRequest
): Promise<CardScan[]> => {
    const fReq = await fetch(
        `${API_URL}/api/card_scans/history?date=${req.date?.toISOString()}&timePeriod=${req.timePeriodId}`,
        {
            headers: {
                Accept: 'application/ld+json'
            },
            credentials: 'include'
        }
    );

    if (!fReq.ok) {
        throw new Error(fReq.statusText);
    }

    const body = await fReq.json();

    return body['hydra:member'];
};
