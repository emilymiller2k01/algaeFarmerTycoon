const BubblesSVG = ({className = ""}: ClassProps) => {
    return (
        <svg className={className} xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
            <path d="M22 22C24.2782 22 26.125 23.8468 26.125 26.125C26.125 28.4032 24.2782 30.25 22 30.25C19.7218 30.25 17.875 28.4032 17.875 26.125C17.875 23.8468 19.7218 22 22 22ZM8.25 16.5C11.2876 16.5 13.75 18.9625 13.75 22C13.75 25.0375 11.2876 27.5 8.25 27.5C5.21243 27.5 2.75 25.0375 2.75 22C2.75 18.9625 5.21243 16.5 8.25 16.5ZM22 24.75C21.2406 24.75 20.625 25.3656 20.625 26.125C20.625 26.8844 21.2406 27.5 22 27.5C22.7594 27.5 23.375 26.8844 23.375 26.125C23.375 25.3656 22.7594 24.75 22 24.75ZM8.25 19.25C6.73122 19.25 5.5 20.4812 5.5 22C5.5 23.5188 6.73122 24.75 8.25 24.75C9.76878 24.75 11 23.5188 11 22C11 20.4812 9.76878 19.25 8.25 19.25ZM19.9375 2.75C24.1142 2.75 27.5 6.13584 27.5 10.3125C27.5 14.4892 24.1142 17.875 19.9375 17.875C15.7608 17.875 12.375 14.4892 12.375 10.3125C12.375 6.13584 15.7608 2.75 19.9375 2.75ZM19.9375 5.5C17.2796 5.5 15.125 7.65462 15.125 10.3125C15.125 12.9704 17.2796 15.125 19.9375 15.125C22.5954 15.125 24.75 12.9704 24.75 10.3125C24.75 7.65462 22.5954 5.5 19.9375 5.5Z" fill="#FFE600" fillOpacity="0.8" />
        </svg>

    );
}

export default BubblesSVG;

export type ClassProps = {
    className?: string
}