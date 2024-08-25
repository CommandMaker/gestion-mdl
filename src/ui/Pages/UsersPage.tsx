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
import { delete_user, getAllUsers } from '~/api';
import { User } from '~/types/server/entities';
import {
    FilledButton,
    UserManagementActions,
    UserSubscriptionTag
} from '~/ui/Atoms';
import { Modal, SortableTable } from '~/ui/Organisms';

export const UsersPage = (): React.ReactElement => {
    const [users, setUsers] = useState<User[]>();
    const [modal, setModal] = useState<React.ReactElement>();

    const handleModalShowChange = (): void => {
        setModal(undefined);
    };

    const onUserDelete = useCallback((user: User) => {
        const action = () => {
            delete_user(user).then(d => {
                if (d.status !== 'ok') throw new Error(d.message as string);
                setModal(undefined);
                setUsers(u => u?.filter(u1 => u1.id !== user.id));
            });
        };

        setModal(
            <Modal
                onClose={handleModalShowChange}
                title="Confirmer"
                buttons={
                    <>
                        <FilledButton
                            label="Oui"
                            onClick={_ => action()}
                            buttonType="danger"
                            style={{ width: '100%' }}
                        />
                    </>
                }
            >
                Voulez-vous vraiment supprimer&nbsp;
                <strong>
                    {user.firstname} {user.lastname}
                </strong>
                &nbsp;?
            </Modal>
        );
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

            {modal}

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
