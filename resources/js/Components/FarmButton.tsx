import React from 'react'
const FarmButton: React.FC<FarmButtonProps> = ({ title, selected, onClick }) => {
    return (
        <button className={`px-6 py-3 text-2xl hover:text-green hover:bg-grey-light text-left font-semibold rounded-lg ${selected ? "bg-grey-light text-green" : " bg-grey text-green-dark"}` }>
            {title}
            </button>
    )
}

export default FarmButton;

export type FarmButtonProps = {
    title: string,
    selected: boolean,
    onClick: () => void;
}

