import React from 'react'

const ExpansionButton = (props: ExpansionButtonProps) => {
    return (
        <button className="flex flex-col items-center justify-center bg-grey text-green-dark hover:text-green hover:bg-grey-light rounded-md">
            <h1 className="text-2xl text-center p-2">
                {props.title}
            </h1>
        </button>
    )
}

export default ExpansionButton

export type ExpansionButtonProps = {
    title: string
}