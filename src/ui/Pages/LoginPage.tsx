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
import { useCallback, useState } from 'react';
import { post_login_user } from '~/api';
import { useNavigate } from 'react-router-dom';
import { MDLIcon } from '../Atoms/Icons/Icons';

type UserData = {
    username?: string;
    password?: string;
};

export const LoginPage = (): React.ReactElement => {
    const [userData, setUserData] = useState<UserData>({});
    const navigate = useNavigate();

    const loginUser = useCallback(
        (e: React.FormEvent) => {
            e.preventDefault();
            e.stopPropagation();

            post_login_user(userData).then(_ => {
                navigate('/');
            });
        },
        [userData]
    );

    return (
        <main className={Styles.Container}>
            <form className={Styles.FormContainer} onSubmit={loginUser}>
                <MDLIcon />

                <h1 style={{ marginTop: '2rem' }}>Se connecter</h1>

                <label htmlFor="username">Membre du CA ayant les clefs</label>
                <Select
                    options={[{ label: 'Ethan TOULON', value: 'an0181' }]}
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
    );
};
