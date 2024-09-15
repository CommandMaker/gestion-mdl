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

import React, { memo, useState } from 'react';
import Styles from './HourSelector.module.scss';
import { TextRadio } from '~/ui/Atoms';
import { TimePeriod } from '~/types/server/entities';

type HourSelectorProps = {
    /**
     * HTML name of the radios buttons
     */
    name: string;

    /**
     * The hours objects used to populate the selector
     */
    data: TimePeriod[];

    /**
     * Function triggered when an hour is selected
     */
    onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
};

export const HourSelector = memo(
    ({ name, data, onChange }: HourSelectorProps): React.ReactElement => {
        const [selectedHour, setHour] = useState<string>();

        const populate = (): React.ReactElement[] =>
            data.map((d, i) => (
                <TextRadio
                    id={d.displayName}
                    name={name}
                    onChange={onSelected}
                    label={d.displayName}
                    value={d['@id']}
                    key={d['@id']}
                    checked={
                        selectedHour === undefined
                            ? i === 0
                            : selectedHour === d['@id']
                    }
                />
            ));

        const onSelected = (e: React.ChangeEvent<HTMLInputElement>): void => {
            setHour(e.target.value);
            onChange(e);
        };

        return (
            <div className={Styles.HourSelector}>
                <span style={{ fontWeight: 'bold' }}>Heure :</span>
                {populate()}
            </div>
        );
    }
);
