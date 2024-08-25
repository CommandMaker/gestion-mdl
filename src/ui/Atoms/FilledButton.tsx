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

import { MouseEvent, memo } from 'react';

import Styles from './FilledButton.module.scss';

type FilledButtonProps = {
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

    style?: React.CSSProperties;

    buttonType?: 'normal' | 'success' | 'danger';
};

export const FilledButton = memo(
    ({
        label,
        title,
        icon,
        style,
        onClick,
        buttonType = 'normal'
    }: FilledButtonProps): React.ReactElement => {
        return (
            <button
                title={title}
                style={{
                    background:
                        buttonType === 'normal'
                            ? 'var(--blue-gray-400)'
                            : 'var(--red-400)',
                    ...style
                }}
                className={Styles.Button}
                onClick={onClick}
            >
                {icon} {label}
            </button>
        );
    }
);
