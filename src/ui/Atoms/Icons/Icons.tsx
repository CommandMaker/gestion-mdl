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

/**
 * All icons are gathered from FontAwesome Pro 6
 */

type IconsProps = {
    /**
     * The size of the icon (width and height)
     */
    size?: number;

    /**
     * The color of the icon
     */
    color?: string;

    /**
     * Class names of the icon (if needed, optional)
     */
    className?: string;
};

export const ScannerTouchScreenIcon = ({
    size = 20,
    color = 'var(--blue-gray-700)',
    className = ''
}: IconsProps): React.ReactElement => {
    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
            className={className}
            width={size}
            height={size}
            fill={color}
        >
            <path d="M192 16C192 7.199 184.801 0 176 0H144C135.201 0 128 7.199 128 16V64H192V16ZM256 16C256 7.199 248.801 0 240 0S224 7.199 224 16V64H256V16ZM496 0H464C455.201 0 448 7.199 448 16V272C448 280.801 455.201 288 464 288H496C504.801 288 512 280.801 512 272V16C512 7.199 504.801 0 496 0ZM288 96H64C28.654 96 0 124.654 0 160V448C0 483.346 28.654 512 64 512H288C323.348 512 352 483.346 352 448V160C352 124.654 323.348 96 288 96ZM304 448C304 456.822 296.822 464 288 464H64C55.178 464 48 456.822 48 448V160C48 151.178 55.178 144 64 144H288C296.822 144 304 151.178 304 160V448ZM400 0C391.199 0 384 7.199 384 16V272C384 280.799 391.199 288 400 288S416 280.799 416 272V16C416 7.199 408.801 0 400 0ZM336 0H304C295.201 0 288 7.199 288 16V64H352V16C352 7.199 344.801 0 336 0Z" />
        </svg>
    );
};

export const ClockIcon = ({
    size = 20,
    color = 'var(--blue-gray-700)',
    className = ''
}: IconsProps): React.ReactElement => {
    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
            width={size}
            height={size}
            className={className}
            fill={color}
        >
            <path d="M256 16C123.451 16 16 123.453 16 256S123.451 496 256 496S496 388.547 496 256S388.549 16 256 16ZM256 448C150.131 448 64 361.867 64 256S150.131 64 256 64S448 150.133 448 256S361.869 448 256 448ZM280 260V152C280 138.75 269.25 128 256 128S232 138.75 232 152V272C232 279.562 235.562 286.656 241.594 291.188L305.594 339.188C309.922 342.438 314.969 344 319.984 344C327.281 344 334.484 340.688 339.203 334.406C347.156 323.781 345 308.75 334.406 300.812L280 260Z" />
        </svg>
    );
};

export const UsersIcon = ({
    size = 20,
    color = 'var(--blue-gray-700)',
    className = ''
}: IconsProps): React.ReactElement => {
    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 640 512"
            width={size}
            height={size}
            className={className}
            fill={color}
        >
            <path d="M319.859 320C377.273 320 423.814 273.436 423.814 216C423.814 158.562 377.273 112 319.859 112C262.451 112 215.904 158.562 215.904 216C215.904 273.436 262.451 320 319.859 320ZM319.859 160C350.713 160 375.814 185.121 375.814 216S350.713 272 319.859 272S263.904 246.879 263.904 216S289.006 160 319.859 160ZM512 160C556.184 160 592 124.182 592 80S556.184 0 512 0C467.82 0 432 35.818 432 80S467.82 160 512 160ZM369.887 352H270.113C191.631 352 128 411.693 128 485.332C128 500.059 140.727 512 156.422 512H483.578C499.273 512 512 500.059 512 485.332C512 411.693 448.377 352 369.887 352ZM178.977 464C189.451 427.236 226.34 400 270.113 400H369.887C413.66 400 450.549 427.236 461.023 464H178.977ZM551.92 192H490.08C477.279 192 465.195 195.037 454.221 200.24C454.834 205.475 455.814 210.604 455.814 216C455.814 249.715 443.033 280.211 422.65 304H622.385C632.113 304 640 295.641 640 285.332C640 233.785 600.566 192 551.92 192ZM183.906 216C183.906 210.551 184.889 205.371 185.516 200.088C174.613 194.967 162.613 192 149.92 192H88.08C39.438 192 0 233.785 0 285.332C0 295.641 7.887 304 17.615 304H217.07C196.688 280.211 183.906 249.715 183.906 216ZM128 160C172.184 160 208 124.182 208 80S172.184 0 128 0C83.82 0 48 35.818 48 80S83.82 160 128 160Z" />
        </svg>
    );
};

export const GavelIcon = ({
    size = 20,
    color = 'var(--blue-gray-700)',
    className = ''
}: IconsProps): React.ReactElement => {
    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
            width={size}
            height={size}
            className={className}
            fill={color}
        >
            <path d="M512 216C512 206.921 504.991 192.116 488.282 192.116C482.543 192.116 476.789 194.18 472.195 198.258L313.742 39.805C317.82 35.212 319.885 29.457 319.885 23.719C319.885 7.028 305.218 0 296 0C289.859 0 283.719 2.344 279.031 7.031L151.031 135.031C146.344 139.719 144 145.859 144 152C144 164.79 154.298 176 168 176C173.689 176 179.27 173.766 183.805 169.742L246.062 232L175.02 303.043L169.363 297.387C163.113 291.139 154.927 288.015 146.74 288.015S130.367 291.139 124.117 297.387L9.375 412.133C3.125 418.381 0 426.567 0 434.754S3.125 451.127 9.375 457.375L54.621 502.625C60.871 508.875 69.058 512 77.245 512S93.619 508.875 99.869 502.625L214.611 387.883C220.862 381.632 223.987 373.446 223.987 365.259C223.987 357.074 220.863 348.888 214.613 342.637L208.957 336.98L280 265.938L342.258 328.195C338.18 332.788 336.115 338.543 336.115 344.281C336.115 360.972 350.782 368 360 368C366.141 368 372.281 365.656 376.969 360.969L504.969 232.969C509.656 228.281 512 222.141 512 216ZM376 294.062L217.938 136L280 73.938L438.062 232L376 294.062Z "></path>
        </svg>
    );
};

export const ChartLineUpIcon = ({
    size = 20,
    color = 'var(--blue-gray-700)',
    className = ''
}: IconsProps): React.ReactElement => {
    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
            width={size}
            height={size}
            className={className}
            fill={color}
        >
            <path d="M488 432H48V56C48 42.744 37.254 32 24 32S0 42.744 0 56V448C0 465.6 14.4 480 32 480H488C501.254 480 512 469.254 512 456C512 442.744 501.254 432 488 432ZM144.969 304.969L208 241.938L287.031 320.969C291.719 325.656 297.844 328 304 328S316.281 325.656 320.969 320.969L432 209.938V264C432 277.25 442.75 288 456 288S480 277.25 480 264V152C480 138.75 469.25 128 456 128H344C330.75 128 320 138.75 320 152S330.75 176 344 176H398.062L304 270.062L224.969 191.031C215.594 181.656 200.406 181.656 191.031 191.031L111.031 271.031C101.656 280.406 101.656 295.594 111.031 304.969S135.594 314.344 144.969 304.969Z" />
        </svg>
    );
};

export const SignatureIcon = ({
    size = 20,
    color = 'var(--blue-gray-700)',
    className = ''
}: IconsProps): React.ReactElement => {
    return (
        <svg
            viewBox="0 0 20 14"
            xmlns="http://www.w3.org/2000/svg"
            width={size}
            height={size}
            className={className}
            fill={color}
        >
            <path d="M0 10.7494C0 11.1636 0.335781 11.4994 0.75 11.4994H4V9.99937H0.75C0.335781 9.99937 0 10.3352 0 10.7494ZM19.25 6.99937H15.791L16.4619 4.98668C16.5498 4.72106 16.4834 4.42809 16.2881 4.22693C16.0928 4.02577 15.8027 3.95349 15.5342 4.03062L11.2344 5.32068C11.3916 4.41149 11.4824 3.58824 11.4981 2.95056C11.5322 1.50718 10.5469 0.254274 9.20606 0.0364929C7.91675 -0.173945 6.582 0.534837 6.12366 1.92734C6.03491 2.19699 6 2.48306 6 2.76696V3.99937C6 4.41359 6.33578 4.74937 6.75 4.74937C7.16422 4.74937 7.5 4.41359 7.5 3.99937V2.82856C7.5 2.44393 7.64016 2.05874 7.93009 1.80602C8.21494 1.55771 8.58084 1.45559 8.96581 1.51696C9.57031 1.61559 10.0147 2.21618 9.99806 2.9154C9.9795 3.69665 9.84181 4.71715 9.61622 5.80602L6.46094 6.75231C5.59384 7.01237 5 7.81043 5 8.71568V11.8702C5 12.8467 5.64419 13.7524 6.59981 13.9529C7.47188 14.1358 8.31853 13.7742 8.76756 13.0722C9.67772 11.6553 10.4141 9.00818 10.8926 6.98962L14.582 5.88318L14.0381 7.51209C13.9619 7.74059 14.001 7.99256 14.1416 8.18787C14.2822 8.38318 14.5088 8.49937 14.75 8.49937H19.25C19.6642 8.49937 20 8.16359 20 7.74937C20 7.33518 19.6642 6.99937 19.25 6.99937ZM7.50488 12.2627C7.41113 12.4092 7.23731 12.5 7.04981 12.5C6.74706 12.5 6.5 12.2529 6.5 11.9502V8.71618C6.5 8.47496 6.66112 8.25915 6.89256 8.18981L9.21094 7.49352C8.76075 9.14196 8.15625 11.25 7.50488 12.2627ZM19.25 9.99937H11.1205C10.9532 10.5466 10.7848 11.0469 10.6147 11.4994H19.25C19.6642 11.4994 20 11.1636 20 10.7494C20 10.3352 19.6642 9.99937 19.25 9.99937Z" />
        </svg>
    );
};

export const RightFromBracketIcon = ({
    size = 20,
    color = 'var(--blue-gray-700)',
    className = ''
}: IconsProps): React.ReactElement => {
    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
            width={size}
            height={size}
            className={className}
            fill={color}
        >
            <path d="M168 432H96C69.6 432 48 410.398 48 384V128C48 101.602 69.6 80 96 80H168C181.254 80 192 69.254 192 56C192 42.742 181.254 32 168 32H96C42.98 32 0 74.98 0 128V384C0 437.02 42.98 480 96 480H168C181.254 480 192 469.254 192 456C192 442.742 181.254 432 168 432ZM503.938 238.555L351.5 104.422C341.656 95.672 327.5 93.547 315.406 98.953C303.625 104.266 296 115.922 296 128.672V183.984H176C153.938 183.984 136 201.922 136 223.984V287.984C136 310.047 153.938 327.984 176 327.984H296V383.297C296 396.047 303.625 407.703 315.406 413.016C319.844 415.016 324.562 415.984 329.25 415.984C337.312 415.984 345.281 413.078 351.5 407.547L503.938 274.43C509.062 269.898 512 263.367 512 256.492S509.062 243.086 503.938 238.555ZM344 350.016V279.984H184V231.984H344V161.953L451.844 256.492L344 350.016Z" />
        </svg>
    );
};

export const ArrowUpIcon = ({
    size = 20,
    color = 'var(--blue-gray-400)',
    className = ''
}: IconsProps): React.ReactElement => {
    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 384 512"
            width={size}
            height={size}
            fill={color}
            className={className}
        >
            <path d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z" />
        </svg>
    );
};

export const TrashIcon = ({
    size = 20,
    color = 'var(--blue-gray-400)',
    className = ''
}: IconsProps): React.ReactElement => {
    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 448 512"
            width={size}
            height={size}
            fill={color}
            className={className}
        >
            <path d="M424 80H349.625L315.625 23.25C306.875 8.875 291.25 0 274.375 0H173.625C156.75 0 141.125 8.875 132.375 23.25L98.375 80H24C10.745 80 0 90.745 0 104V104C0 117.255 10.745 128 24 128H32L53.25 467C54.75 492.25 75.75 512 101.125 512H346.875C372.25 512 393.25 492.25 394.75 467L416 128H424C437.255 128 448 117.255 448 104V104C448 90.745 437.255 80 424 80ZM173.625 48H274.375L293.625 80H154.375L173.625 48ZM346.875 464H101.125L80.125 128H367.875L346.875 464Z" />
        </svg>
    );
};

export const XMarkIcon = ({
    size = 20,
    color = 'var(--blue-gray-400)',
    className = ''
}: IconsProps): React.ReactElement => {
    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
            width={size}
            height={size}
            fill={color}
            className={className}
        >
            <path d="M256 16C123.451 16 16 123.451 16 256S123.451 496 256 496S496 388.549 496 256S388.549 16 256 16ZM256 448C150.131 448 64 361.869 64 256S150.131 64 256 64S448 150.131 448 256S361.869 448 256 448ZM336.969 175.031C327.594 165.656 312.406 165.656 303.031 175.031L256 222.062L208.969 175.031C199.594 165.656 184.406 165.656 175.031 175.031S165.656 199.594 175.031 208.969L222.062 255.998L175.031 303.029C165.656 312.404 165.656 327.592 175.031 336.967C184.404 346.34 199.588 346.348 208.969 336.967L256 289.936L303.031 336.967C312.404 346.34 327.588 346.348 336.969 336.967C346.344 327.592 346.344 312.404 336.969 303.029L289.938 255.998L336.969 208.969C346.344 199.594 346.344 184.406 336.969 175.031Z" />
        </svg>
    );
};

export const CheckIcon = ({
    size = 20,
    color = 'var(--blue-gray-400)',
    className = ''
}: IconsProps): React.ReactElement => {
    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
            width={size}
            height={size}
            fill={color}
            className={className}
        >
            <path d="M480.969 128.969L208.969 400.969C204.281 405.656 198.156 408 192 408S179.719 405.656 175.031 400.969L31.031 256.969C21.656 247.594 21.656 232.406 31.031 223.031S55.594 213.656 64.969 223.031L192 350.062L447.031 95.031C456.406 85.656 471.594 85.656 480.969 95.031S490.344 119.594 480.969 128.969Z" />
        </svg>
    );
};

export const PenIcon = ({
    size = 20,
    color = 'var(--blue-gray-400)',
    className = ''
}: IconsProps): React.ReactElement => {
    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
            width={size}
            height={size}
            fill={color}
            className={className}
        >
            <path d="M455.703 18.748C443.209 6.252 426.829 0 410.452 0C394.07 0 377.695 6.25 365.196 18.75L45.11 338.885C36.542 347.451 30.584 358.275 27.926 370.094L0.319 492.854C-1.701 502.967 6.158 512 15.946 512C16.993 512 18.061 511.896 19.143 511.68C19.143 511.68 103.751 493.73 141.894 484.748C153.432 482.031 163.759 476.225 172.139 467.844C221.264 418.719 406.649 233.33 493.302 146.676C518.294 121.684 518.202 81.256 493.212 56.262L455.703 18.748ZM138.201 433.902C136.086 436.018 133.697 437.365 130.893 438.025C112.719 442.307 83.432 448.738 58.204 454.203L74.751 380.627C75.417 377.668 76.902 374.973 79.048 372.824L320.936 130.902L381.064 191.035L138.201 433.902Z" />
        </svg>
    );
};

export const IdCardIcon = ({
    size = 20,
    color = 'var(--blue-gray-400)',
    className = ''
}: IconsProps): React.ReactElement => {
    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 576 512"
            width={size}
            height={size}
            fill={color}
            className={className}
        >
            <path d="M368 344H464C477.25 344 488 333.25 488 320S477.25 296 464 296H368C354.75 296 344 306.75 344 320S354.75 344 368 344ZM208 320C243.346 320 272 291.346 272 256C272 220.652 243.346 192 208 192S144 220.652 144 256C144 291.346 172.654 320 208 320ZM512 32H64C28.654 32 0 60.654 0 96V416C0 451.346 28.654 480 64 480H512C547.346 480 576 451.346 576 416V96C576 60.654 547.346 32 512 32ZM528 416C528 424.822 520.822 432 512 432H320C320 387.816 284.184 352 240 352H176C131.816 352 96 387.816 96 432H64C55.178 432 48 424.822 48 416V160H528V416ZM368 264H464C477.25 264 488 253.25 488 240S477.25 216 464 216H368C354.75 216 344 226.75 344 240S354.75 264 368 264Z" />
        </svg>
    );
};
