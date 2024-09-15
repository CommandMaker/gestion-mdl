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

import { Input, Select } from 'antd';
import Styles from './LoginPage.module.scss';
import { FilledButton } from '../Atoms';
import { useCallback, useEffect, useState } from 'react';
import { post_login_user, get_all_users } from '~/api';
import { useNavigate } from 'react-router-dom';
import { MDLIcon } from '../Atoms/Icons/Icons';
import { User } from '~/types/server/entities';
import { useUserStore } from '~/stores';

type UserData = {
    username: string;
    password: string;
};

type LoginUserSelectOption = {
    label: string;
    value: string;
};

export const LoginPage = (): React.ReactElement => {
    const [userData, setUserData] = useState<Partial<UserData>>({});
    const navigate = useNavigate();
    const [users, setUsers] = useState<User[] | undefined>();
    const userStore = useUserStore();

    const loginUser = useCallback(
        (e: React.FormEvent) => {
            e.preventDefault();
            e.stopPropagation();

            userStore.login(userData as UserData).then(() => navigate('/'));
        },
        [userData]
    );

    useEffect(() => {
        get_all_users().then(users => setUsers(users));
    }, []);

    const getLoggableUsers = (): LoginUserSelectOption[] => {
        return users!
            .map(user =>
                user.isAdmin
                    ? ({
                          label: `${user.firstname} ${user.lastname} (${user.grade})`,
                          value: user.code
                      } as LoginUserSelectOption)
                    : null
            )
            .filter(u => u !== null) as LoginUserSelectOption[];
    };

    return users ? (
        <main className={Styles.Container}>
            <form className={Styles.FormContainer} onSubmit={loginUser}>
                <MDLIcon />

                <h1 style={{ marginTop: '2rem' }}>Se connecter</h1>

                <label htmlFor="username">Membre du CA ayant les clefs</label>
                <Select
                    options={getLoggableUsers()}
                    placeholder="Choisissez votre nom"
                    onChange={e => setUserData(s => ({ ...s, username: e }))}
                />

                <label htmlFor="password">Mot de passe</label>
                <Input
                    type="password"
                    placeholder="Mot de passe"
                    onChange={e =>
                        setUserData(s => ({ ...s, password: e.target.value }))
                    }
                />

                <FilledButton label="Se connecter" htmlType="submit" />
            </form>
        </main>
    ) : (
        <></>
    );
};
