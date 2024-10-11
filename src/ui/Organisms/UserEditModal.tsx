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
import { Modal } from '~/ui/Organisms';
import { FilledButton } from '../Atoms';
import { useCallback, useEffect, useState } from 'react';
import { omit } from '~/utils';
import { Checkbox, Input, Select } from 'antd';
import { patch_edit_user, post_create_user } from '~/api';
import { UserData } from '~/types/server/requests';
import { useSubscriptionTypeStore } from '~/stores';

type UserEditModalProps = {
    user?: User;
    onClose: (user?: User) => void;
};

export const UserEditModal = ({ user, onClose }: UserEditModalProps) => {
    const [userData, setUserData] = useState<UserData>(
        user
            ? omit(user, [
                  'subscriptionEnd',
                  'subscriptionValidity',
                  'subscriptionType',
                  'password'
              ])
            : {
                  gender: 'male'
              }
    );
    const subscriptionTypeStore = useSubscriptionTypeStore();

    const submitUser = useCallback(() => {
        if (user) {
            patch_edit_user(userData).then(onClose);

            return;
        }

        post_create_user(userData).then(onClose);
    }, [userData]);

    useEffect(() => {
        subscriptionTypeStore.fetchData();

        if (subscriptionTypeStore.subscriptionTypes !== undefined) {
            setUserData(s => ({
                ...s,
                subscriptionType:
                    subscriptionTypeStore.subscriptionTypes![0]['@id']
            }));
        }

        user
            ? setUserData(s => ({
                  ...s,
                  subscriptionType: user.subscriptionType['@id']
              }))
            : undefined;
    }, []);

    return subscriptionTypeStore.subscriptionTypes ? (
        <Modal
            onClose={onClose}
            wrapperId="editModal"
            title={user ? "Editer l'adhérent" : 'Créer un adhérent'}
            buttons={
                <>
                    <FilledButton
                        label="Valider"
                        onClick={submitUser}
                        style={{ width: '100%' }}
                    />
                </>
            }
        >
            <div
                style={{
                    display: 'flex',
                    flexDirection: 'column',
                    gap: '1rem',
                    minWidth: '450px'
                }}
            >
                <label htmlFor="firstname">Prénom</label>
                <Input
                    placeholder="Prénom"
                    onChange={e =>
                        setUserData(s => ({ ...s, firstname: e.target.value }))
                    }
                    value={userData.firstname}
                    id="firstname"
                />

                <label htmlFor="lastname">Nom de famille</label>
                <Input
                    placeholder="Nom de famille"
                    onChange={e =>
                        setUserData(s => ({ ...s, lastname: e.target.value }))
                    }
                    value={userData.lastname}
                    id="lastname"
                />

                <div style={{ display: 'flex', gap: '1rem' }}>
                    <div
                        style={{
                            display: 'flex',
                            flexDirection: 'column',
                            gap: '1rem',
                            width: '100%'
                        }}
                    >
                        <label htmlFor="grade">Classe</label>
                        <Input
                            placeholder="Classe"
                            onChange={e =>
                                setUserData(s => ({
                                    ...s,
                                    grade: e.target.value
                                }))
                            }
                            value={userData.grade}
                            id="grade"
                        />
                    </div>

                    <div
                        style={{
                            display: 'flex',
                            flexDirection: 'column',
                            gap: '1rem',
                            width: '100%'
                        }}
                    >
                        <label htmlFor="code">Code de carte</label>
                        <Input
                            placeholder="Code de carte"
                            onChange={e =>
                                setUserData(s => ({
                                    ...s,
                                    code: e.target.value
                                }))
                            }
                            value={userData.code}
                            id="code"
                        />
                    </div>
                </div>

                <div style={{ display: 'flex', gap: '1rem' }}>
                    <div
                        style={{
                            display: 'flex',
                            flexDirection: 'column',
                            gap: '1rem',
                            width: '100%'
                        }}
                    >
                        <label htmlFor="gender">Genre</label>
                        <Select
                            id="gender"
                            options={[
                                { label: 'Homme', value: 'male' },
                                { label: 'Femme', value: 'female' }
                            ]}
                            defaultValue="male"
                            value={userData.gender}
                            onChange={e =>
                                setUserData(s => ({ ...s, gender: e }))
                            }
                        />
                    </div>

                    <div
                        style={{
                            display: 'flex',
                            flexDirection: 'column',
                            gap: '1rem',
                            width: '100%'
                        }}
                    >
                        <label htmlFor="subscriptionType">
                            Type d'abonnement
                        </label>
                        <Select
                            id="subscriptionType"
                            options={subscriptionTypeStore.subscriptionTypes!.map(
                                st => ({
                                    label: st.displayName,
                                    value: st['@id']
                                })
                            )}
                            defaultValue={
                                subscriptionTypeStore.subscriptionTypes![0][
                                    '@id'
                                ] || undefined
                            }
                            value={userData.subscriptionType}
                            onChange={e =>
                                setUserData(s => ({
                                    ...s,
                                    subscriptionType: e
                                }))
                            }
                        />
                    </div>
                </div>

                <div
                    style={{
                        display: 'flex',
                        gap: '0.5rem',
                        alignItems: 'center'
                    }}
                >
                    <Checkbox
                        id="isAdmin"
                        onChange={e =>
                            setUserData(s => ({
                                ...s,
                                isAdmin: e.target.checked
                            }))
                        }
                        checked={userData.isAdmin}
                    />
                    <label htmlFor="isAdmin">
                        Fait-il parti du Conseil d'Administration ?
                    </label>
                </div>

                {userData.isAdmin && user === undefined ? (
                    <>
                        <label htmlFor="password">Mot de passe</label>
                        <Input
                            type="password"
                            id="password"
                            value={userData.password}
                            onChange={e =>
                                setUserData(s => ({
                                    ...s,
                                    password: e.target.value
                                }))
                            }
                            placeholder="Mot de passe"
                        />
                    </>
                ) : undefined}
            </div>
        </Modal>
    ) : (
        <></>
    );
};
