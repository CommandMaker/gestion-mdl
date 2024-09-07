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

import React, { useCallback } from 'react';
import Styles from './Dashboard.module.scss';
import {
    Button,
    Divider,
    ChartLineUpIcon,
    ClockIcon,
    GavelIcon,
    ScannerTouchScreenIcon,
    SignatureIcon,
    UsersIcon,
    RightFromBracketIcon
} from '~/ui/Atoms';
import { useLocation, useNavigate } from 'react-router-dom';
import { User } from '~/types/server/entities';
import { get_logout } from '~/api';
import { MDLIcon } from '../Atoms/Icons/Icons';

export const Dashboard = ({ user }: { user: User }): React.ReactElement => {
    const { pathname: location } = useLocation();
    const navigate = useNavigate();

    const handleLogout = useCallback(() => {
        get_logout().then(_ => navigate('/login'));
    }, []);

    return (
        <aside className={Styles.Container}>
            <div
                style={{
                    overflowY: 'auto',
                    padding: '48px 25px',
                    width: 'calc(100% - 20px)',
                    height: 'calc(100vh - 40px)',
                    marginTop: '10px'
                }}
            >
                <div
                    style={{
                        marginBottom: '1.5rem',
                        display: 'flex',
                        gap: '1rem',
                        flexDirection: 'column'
                    }}
                >
                    <MDLIcon />
                    <p style={{ fontSize: '0.80rem' }}>
                        Connecté en tant que{' '}
                        <strong style={{ fontSize: '0.80rem' }}>
                            {user.firstname} {user.lastname}
                        </strong>
                    </p>
                </div>

                <ul className={Styles.ButtonList}>
                    <Button
                        label="Entrées cette heure-ci"
                        onClick={() => navigate('/')}
                        selected={location === '/'}
                        icon={<ScannerTouchScreenIcon />}
                    />
                    <Button
                        label="Historique des entrées"
                        onClick={() => navigate('/history')}
                        selected={location === '/history'}
                        icon={<ClockIcon />}
                    />
                </ul>

                <Divider />

                <ul className={Styles.ButtonList}>
                    <Button
                        label="Adhérents"
                        onClick={() => navigate('/adherents')}
                        icon={<UsersIcon />}
                        selected={location === '/adherents'}
                    />
                    <Button
                        label="Sanctions"
                        onClick={() => {}}
                        icon={<GavelIcon />}
                        selected={location === '/sanctions'}
                    />
                </ul>

                <Divider />

                <ul className={Styles.ButtonList}>
                    <Button
                        label="Statistiques"
                        onClick={() => {}}
                        icon={<ChartLineUpIcon />}
                        selected={location === '/stats'}
                    />
                    <Button
                        label="Historique des ouvertures"
                        onClick={() => {}}
                        icon={<SignatureIcon />}
                        selected={location === '/opens'}
                    />
                    <Button
                        label="Horaires"
                        onClick={() => {}}
                        icon={<SignatureIcon />}
                        selected={location === 'hours'}
                    />
                </ul>

                <Button
                    label="Se déconnecter"
                    onClick={handleLogout}
                    icon={<RightFromBracketIcon color="var(--red-700)" />}
                    selected={location === '/settings'}
                    style={{
                        width: '280px',
                        position: 'absolute',
                        bottom: 30,
                        color: 'var(--red-700)'
                    }}
                />
            </div>
        </aside>
    );
};
