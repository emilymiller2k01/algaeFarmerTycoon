import { ClassProps } from "./BubblesSVG";

const FarmSVG = ({ className = "" }: ClassProps) => {
    return (
        <svg className={className} xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">
            <path d="M15.7083 22.958H22.9583V12.0566L14.5 5.47793L6.04167 12.0566V22.958H13.2917V15.708H15.7083V22.958ZM25.375 24.1663C25.375 24.8337 24.834 25.3746 24.1667 25.3746H4.83333C4.166 25.3746 3.625 24.8337 3.625 24.1663V11.4657C3.625 11.0928 3.79715 10.7408 4.09149 10.5119L13.7582 2.99334C14.1945 2.65397 14.8055 2.65397 15.2418 2.99334L24.9085 10.5119C25.2028 10.7408 25.375 11.0928 25.375 11.4657V24.1663Z" fill="#FFE600" fill-opacity="0.8" />
        </svg>

    );
}

export default FarmSVG;