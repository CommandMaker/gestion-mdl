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
import { BaseResponse } from '~/types/server/response';

export const getHistory = async (
    req: GetHistoryRequest
): Promise<CardScan[]> => {
    const reqData = new FormData();
    const date = new Date();
    reqData.append('timePeriodId', req.timePeriodId.toString());
    reqData.append(
        'date',
        req.date ||
            `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')}`
    );

    const historyReq = await fetch(`${API_URL}/api/scans/get`, {
        method: 'POST',
        headers: {
            Accept: 'application/json'
        },
        body: reqData
    });

    const data: BaseResponse<CardScan[]> = await historyReq.json();

    if (data.status !== 'ok')
        throw new Error(historyReq.statusText + ' : ' + data.message);

    return data.data || [];
};
