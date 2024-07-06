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

import React, { MouseEvent } from 'react';

import Styles from './Button.module.scss';

type ButtonProps = {
    /**
     * Callback triggered when the button is clicked
     */
    onClick: (event: MouseEvent<HTMLButtonElement>) => void;

    /**
     * The title of the button (represent the title attribute of an HTML button)
     */
    title?: string;

    /**
     * The label of the button
     */
    label: string;

    /**
     * The icon displayed at the left of the button (optional)
     */
    icon?: React.ReactElement;

    /**
     * Define if the rendered element is a link or a button
     */
    isLink?: boolean;

    /**
     * If the `isLink` prop is set to true, it will set the href of the link
     */
    href?: string;

    selected?: boolean;
};

export const Button = ({
    onClick,
    title,
    label,
    selected,
    icon
}: ButtonProps): React.ReactElement => {
    return (
        <button
            className={`${Styles.Button} ${selected ? Styles.Selected : ''}`}
            title={title}
            onClick={onClick}
        >
            <p>
                {icon} {label}
            </p>
        </button>
    );
};
