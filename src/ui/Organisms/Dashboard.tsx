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

import React from 'react';
import Styles from './Dashboard.module.scss';
import { Button } from '../Atoms/Button';
import { ChartLineUpIcon, ClockIcon, GavelIcon, ScannerTouchScreenIcon, SignatureIcon, UsersIcon } from '../Atoms/Icons/Icons';
import { Divider } from '../Atoms/Divider';

export const Dashboard = (): React.ReactElement => {
    return <aside className={Styles.Container}>
        <h2 className={Styles.Title}>MDL Beaussier</h2>

        <ul className={Styles.ButtonList}>
            <Button label="Entrées cette heure-ci" onClick={console.log} selected icon={<ScannerTouchScreenIcon />} />
            <Button label="Historique des entrées" href="https://archlinux.org" onClick={console.log} icon={<ClockIcon />} />
        </ul>

        <Divider />

        <ul className={Styles.ButtonList}>
            <Button label="Adhérents" onClick={() => {}} icon={<UsersIcon />} />
            <Button label="Sanctions" onClick={() => {}} icon={<GavelIcon />} />
        </ul>

        <Divider />

        <ul className={Styles.ButtonList}>
            <Button label="Statistiques" onClick={() => {}} icon={<ChartLineUpIcon />} />
            <Button label="Historique des ouvertures" onClick={() => {}} icon={<SignatureIcon />} />
            <Button label="Horaires" onClick={() => {}} icon={<SignatureIcon />} />
        </ul>
    </aside>;
};
