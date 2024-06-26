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
import Styles from './Divider.module.scss';

type DividerProps = {
    /**
     * Direction of the divider (default = 'horizontal')
     */
    direction?: 'horizontal' | 'vertical';

    /**
     * Margin of the divider (default = '2rem')
     */
    margin?: number|string;
}

export const Divider = ({direction = 'horizontal', margin = '2rem'}: DividerProps): React.ReactElement => {
    return <div className={direction === 'vertical' ? Styles.VerticalDivider : Styles.HorizontalDivider} style={{margin: margin}}></div>;
}
