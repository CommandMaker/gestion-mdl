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

export type TimePeriod = {
    '@id': string;
    displayName: string;
    startTime: string;
    endTime: string;
};

export type CardScan = {
    '@id': string;
    code: string;
    date: string;
    timePeriodId: number;
    user: User;
};

export type User = {
    '@id': string;
    firstname: string;
    lastname: string;
    grade: string;
    code: string;
    gender: string;
    subscriptionType: SubscriptionType;
    subscriptionEnd: string;
    subscriptionValidity: boolean;
    isAdmin: boolean;
    password: string;
};

export type SubscriptionType = {
    '@id': string;
    displayName: string;
    duration?: string;
};
