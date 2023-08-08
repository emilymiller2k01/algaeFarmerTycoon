import React from 'react'
const FarmButton = (props: FarmButtonProps) => {
    return (
        <button className={`px-6 py-3 text-2xl hover:text-green hover:bg-grey-light text-left font-semibold rounded-lg ${props.selected ? "bg-grey-light text-green" : " bg-grey text-green-dark"}` }>
            {props.title}
            </button>
    )
}

export default FarmButton;

export type FarmButtonProps = {
    title: string,
    selected: boolean,
}

