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

import { User } from '~/types/server/entities';
import Styles from './UserManagementActions.module.scss';
import { IdCardIcon, PenIcon, TrashIcon } from '~/ui/Atoms';

type UserManagementActionsProps = {
    user: User;
    onDelete: (user: User) => void;
    onEdit: (user: User) => void;
    onCardDump: (user: User) => void;
};

export const UserManagementActions = ({
    user,
    onDelete,
    onCardDump,
    onEdit
}: UserManagementActionsProps): React.ReactElement => {
    return (
        <span className={Styles.Container}>
            <button className={Styles.Button} onClick={_ => onDelete(user)}>
                <TrashIcon color="var(--red-700)" size={25} />
            </button>
            <button className={Styles.Button} onClick={_ => onEdit(user)}>
                <PenIcon size={25} />
            </button>
            <button className={Styles.Button} onClick={_ => onCardDump(user)}>
                <IdCardIcon size={25} />
            </button>
        </span>
    );
};
