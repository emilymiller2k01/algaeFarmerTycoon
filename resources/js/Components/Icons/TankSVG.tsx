import { ClassProps } from "./BubblesSVG";

const TankSVG = ({ className = "" }: ClassProps) => {
    return (
        <svg className={className} xmlns="http://www.w3.org/2000/svg" width="26" height="30" viewBox="0 0 26 30" fill="none">
        <path d="M2.73684 9.07242V20.9276L13 26.8486L23.2632 20.9276V9.07242L13 3.15136L2.73684 9.07242ZM13 0L26 7.5V22.5L13 30L0 22.5V7.5L13 0ZM5.47226 12.2327L11.6316 15.7861V22.6705H14.3684V15.7861L20.5277 12.2327L19.1565 9.87246L13 13.4243L6.84353 9.87246L5.47226 12.2327Z" fill="#42FF00" fill-opacity="0.6"/>
        </svg>

    );
}

export default TankSVG;