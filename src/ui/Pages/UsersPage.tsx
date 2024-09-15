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
import { delete_user, get_all_users } from '~/api';
import { API_URL } from '~/types/constants';
import { User } from '~/types/server/entities';
import {
    FilledButton,
    UserManagementActions,
    UserSubscriptionTag
} from '~/ui/Atoms';
import { Modal, SortableTable, UserEditModal } from '~/ui/Organisms';

export const UsersPage = (): React.ReactElement => {
    const [users, setUsers] = useState<User[]>();
    const [modal, setModal] = useState<React.ReactElement>();

    const handleModalShowChange = (): void => {
        setModal(undefined);
    };

    const onUserDelete = useCallback((user: User) => {
        const action = () => {
            delete_user(user).then(_ => {
                handleModalShowChange();
                setUsers(undefined);
            });
        };

        setModal(
            <Modal
                wrapperId="confirmDelete"
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
        setModal(<UserEditModal user={user} onClose={u => {
            handleModalShowChange()

            if (u === undefined) return;
            const index = users!.indexOf(users!.filter(us => us['@id'] === u['@id'])[0]);

            setUsers(s => {
                s![index] = u;

                return s;
            });
        }} />);
    }, []);

    const onUserCardDump = useCallback((user: User) => {
        window.open(`${API_URL}${user['@id']}/card`, '_blank');
    }, []);

    const openRegisterModal = useCallback(() => {
        setModal(
            <UserEditModal
                onClose={() => {
                    handleModalShowChange();
                    setUsers(undefined);
                }}
            />
        );
    }, []);

    /**
     * Fetch users from the API when the page is loaded
     */
    useEffect(() => {
        if (users !== undefined) return;

        get_all_users().then(users => setUsers(users));
    }, [users]);

    return (
        <main>
            <h1>Gestion des adhérents</h1>

            {modal}

            <FilledButton
                label="Inscrire un nouvel adhérent"
                style={{ marginBottom: '1rem' }}
                onClick={openRegisterModal}
            />

            {users !== undefined ? (
                <>
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
                </>
            ) : (
                <p>Chargement ...</p>
            )}
        </main>
    );
};
