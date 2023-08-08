import React from 'react'
import FarmButton from "./FarmButton"

const FarmsSection = (props: FarmsProps) => {
    return (
        <div className="flex flex-col h-full">
            <div className="flex px-8 py-6 bg-grey items-start">
                <h1 className="text-2xl text-green font-semibold">
                    Farms
                </h1>
            </div>
            <div className="flex flex-col gap-4 py-6 px-8 flex-grow overflow-y-auto">
                <FarmButton title={"Farm 1"} selected/>
                <FarmButton title={"Farm 2"} selected={false}/>
                <FarmButton title={"Farm 3"} selected={false}/>
            </div>

        </div>
    )
}

export default FarmsSection

export type FarmsProps = {
}