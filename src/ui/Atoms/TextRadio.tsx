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
import Styles from './TextRadio.module.scss';

type TextRadioProps = {
    /**
     * HTML id of the button
     */
    id?: string;

    /**
     * HTML name of the radio (must be the same for all linked radio buttons)
     */
    name: string;

    /**
     * The label of the radio
     */
    label: string;

    /**
     * Function triggered when the radio is selected
     */
    onChange: (event: React.ChangeEvent<HTMLInputElement>) => void;

    /**
     * Value of the radio
     */
    value: string;

    /**
     * If the radio is checked by default
     */
    defaultChecked?: boolean;

    /**
     * Used in intern to change selected radio. For a default check, use the `defaultChecked` property
     */
    checked?: boolean;
};

export const TextRadio = ({
    id,
    name,
    label,
    onChange,
    value,
    checked,
    defaultChecked
}: TextRadioProps): React.ReactElement => {
    return (
        <label
            className={`${Styles.TextRadio} ${checked ? Styles.CheckedTextRadio : ''}`}
        >
            <input
                type="radio"
                id={id}
                name={name}
                onChange={onChange}
                value={value}
                defaultChecked={defaultChecked}
            />
            {label}
        </label>
    );
};
