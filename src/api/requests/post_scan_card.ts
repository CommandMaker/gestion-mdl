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

export const post_scan_card = async (
    cardCode: string,
    timePeriod: string
): Promise<CardScan> => {
    const req = await fetch(`${API_URL}/api/card_scans`, {
        method: 'POST',
        headers: {
            Accept: 'application/ld+json',
            'Content-Type': 'application/ld+json'
        },
        body: JSON.stringify({
            code: cardCode,
            timePeriod: timePeriod,
            date: new Date().toISOString()
        }),
        credentials: 'include'
    });

    if (!req.ok) throw new Error(req.statusText);

    return await req.json();
};
