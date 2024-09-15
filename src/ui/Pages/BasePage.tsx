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

import React, { useEffect, useState } from 'react';

import Styles from './BasePage.module.scss';
import { Dashboard } from '~/ui/Organisms/Dashboard';
import { Outlet, useLocation, useNavigate } from 'react-router-dom';
import { get_user } from '~/api';
import { User } from '~/types/server/entities';

export const BasePage = (): React.ReactElement => {
    const location = useLocation();
    const navigate = useNavigate();
    const [user, setUser] = useState<User>();

    useEffect(() => {
        if (location.pathname === '/login') return;

        get_user()
            .then(user => setUser(user))
            .catch(_ => {
                navigate('/login');
            });
    }, [location]);

    return user ? (
        <div className={Styles.GridContainer}>
            <Dashboard user={user!} />
            <Outlet />
        </div>
    ) : (
        <></>
    );
};
