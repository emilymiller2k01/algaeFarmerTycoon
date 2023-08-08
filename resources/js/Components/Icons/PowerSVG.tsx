import { ClassProps } from "./BubblesSVG";

const PowerSVG = ({ className = "" }: ClassProps) => {
    return (
        <svg className={className} xmlns="http://www.w3.org/2000/svg" width="65" height="66" viewBox="0 0 65 66" fill="none">
            <path d="M34.4118 24.75H65L26.7647 66V41.25H0L34.4118 0V24.75ZM26.7647 30.25V19.8567L13.5062 35.75H34.4118V47.8346L50.7115 30.25H26.7647Z" fill="#42FF00" />
        </svg>
    );
}

export default PowerSVG;