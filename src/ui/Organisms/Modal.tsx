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

import { PropsWithChildren, useCallback, useEffect, useLayoutEffect, useRef, useState } from 'react';
import { createPortal } from 'react-dom';
import { v4 } from 'uuid';
import { XMarkIcon } from '~/ui/Atoms';

import Styles from './Modal.module.scss';

type ModalProps = PropsWithChildren & {
    onClose: () => void;
    title: string;
    buttons: React.ReactElement;
};

export const Modal = ({
    children,
    onClose,
    title,
    buttons
}: ModalProps): React.ReactElement => {
    const bodyRef = useRef<HTMLUListElement>(null);

    /**
     * Close the modal when Escape is pressed
     */
    const handleKeyPress = useCallback((e: KeyboardEvent) => {
        if (e.key === 'Escape') {
            onClose();
        }
    }, []);

    /**
     * Close the modal when Escape is pressed
     */
    useEffect(() => {
        document.addEventListener('keydown', handleKeyPress);

        return () => {
            document.removeEventListener('keydown', handleKeyPress);
        };
    }, [handleKeyPress]);

    /**
     * Close the modal when clicking outside
     */
    useEffect(() => {
        const callback = (e: Event): null | undefined => {
            const el = bodyRef?.current;
            if (!el || el.contains((e?.target as Node) || null)) return null;

            onClose();
        }

        document.addEventListener('mousedown', callback);
        document.addEventListener('touchstart', callback);

        return () => {
            document.removeEventListener('mousedown', callback);
            document.removeEventListener('touchstart', callback);
        };
    }, [bodyRef]);

    return (
        <PortalModal containerId={v4()}>
            <ul className={Styles.ModalBackground} ref={bodyRef}>
                <li className={Styles.TitleLine}>
                    <h3>{title}</h3>
                    <button onClick={_ => onClose()} className={Styles.ModalCloseButton}>
                        <XMarkIcon size={25} />
                    </button>
                </li>
                <li>{children}</li>
                <li>{buttons}</li>
            </ul>
        </PortalModal>
    )
};

type PortalModalProps = PropsWithChildren & {
    containerId: string;
};

const PortalModal = ({ children, containerId }: PortalModalProps): React.ReactElement => {
    const [portalElement, setPortalElement] = useState<HTMLElement>();

    /**
     * Mount the modal to the DOM by creating the portal container
     */
    useLayoutEffect(() => {
        let element = document.getElementById(containerId);
        let portalCreated = false;

        if (!element) {
            element = document.createElement('div');
            element.setAttribute('id', containerId);
            element.classList.add(Styles.ModalContainer);
            document.body.appendChild(element);
            portalCreated = true;
        }

        setPortalElement(element);

        return () => {
            if (portalCreated && element.parentNode) {
                element.parentNode.removeChild(element);
                portalCreated = false;
            }
        }
    }, [containerId]);

    if (portalElement === undefined) return <></>;

    return createPortal(children, portalElement);
};
