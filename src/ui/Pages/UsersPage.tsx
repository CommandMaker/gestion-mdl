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

import { useCallback, useEffect, useState } from 'react';
import { getAllUsers } from '~/api';
import { User } from '~/types/server/entities';
import { UserManagementActions, UserSubscriptionTag } from '~/ui/Atoms';
import { SortableTable } from '~/ui/Organisms';

export const UsersPage = (): React.ReactElement => {
    const [users, setUsers] = useState<User[]>();

    const onUserDelete = useCallback((user: User) => {
        console.log('Deleted');
    }, []);

    const onUserEdit = useCallback((user: User) => {
        console.log('Edited');
    }, []);

    const onUserCardDump = useCallback((user: User) => {
        console.log('Card dumped');
    }, []);

    /**
     * Fetch users from the API when the page is loaded
     */
    useEffect(() => {
        getAllUsers().then(users => setUsers(users));
    }, []);

    return (
        <main>
            <h1>Gestion des adhérents</h1>

            {users !== undefined ? (
                <SortableTable
                    stripped
                    data={users}
                    columns={[
                        {
                            label: 'Code',
                            key: 'code',
                            sortable: true,
                            sortFunction: (a, b) =>
                                +((a as string).match(/\d+/) || 0) <
                                +((b as string).match(/\d+/) || 0)
                                    ? -1
                                    : 1,
                            width: '150px'
                        },
                        {
                            label: 'Nom',
                            key: 'lastname',
                            sortable: true
                        },
                        {
                            label: 'Prénom',
                            key: 'firstname',
                            sortable: true
                        },
                        {
                            label: 'Classe',
                            key: 'grade'
                        },
                        {
                            label: 'Abonnement',
                            key: 'subscriptionType.displayName',
                            width: '150px',
                            renderElement: (user: User) => (
                                <UserSubscriptionTag user={user} />
                            )
                        },
                        {
                            label: 'Actions',
                            key: '',
                            width: '200px',
                            renderElement: (row: User) => (
                                <UserManagementActions
                                    user={row}
                                    onDelete={onUserDelete}
                                    onEdit={onUserEdit}
                                    onCardDump={onUserCardDump}
                                />
                            )
                        }
                    ]}
                />
            ) : (
                <p>Chargement ...</p>
            )}
        </main>
    );
};
