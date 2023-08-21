import { ClassProps } from "./BubblesSVG";
import React from "react";

const WindSVG = ({ className = "" }: ClassProps) => {
    return (
        <svg className={className} xmlns="http://www.w3.org/2000/svg" width="61" height="63" viewBox="0 0 61 63" fill="none">
        <g clipPath="url(#clip0_97_1154)">
        <path d="M36.75 45V40.5H46.375C51.6908 40.5 56 36.9743 56 32.625C56 28.2757 51.6908 24.75 46.375 24.75C43.6814 24.75 41.2465 25.6552 39.4995 27.1141C39.4997 27.076 39.5 27.038 39.5 27C39.5 19.5442 32.1127 13.5 23 13.5C13.8873 13.5 6.5 19.5442 6.5 27V27.0155H1V27C1 17.0589 10.8497 9 23 9C32.336 9 40.3137 13.758 43.5084 20.4719C44.4365 20.3263 45.3949 20.25 46.375 20.25C54.7284 20.25 61.5 25.7905 61.5 32.625C61.5 39.4596 54.7284 45 46.375 45H36.75ZM14.75 49.5H42.25V54H14.75V49.5ZM14.75 31.5H36.75V36H14.75V31.5ZM3.75 40.5H31.25V45H3.75V40.5Z" fill="#42FF00"/>
        </g>
        <defs>
        <clipPath id="clip0_97_1154">
        <rect width="61" height="63" fill="white"/>
        </clipPath>
        </defs>
        </svg>

    );
}

export default WindSVG;
