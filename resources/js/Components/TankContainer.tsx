import React from 'react'
import Tank from "./Tank"

const TankContainer = (props: TankContainerProps) => {
    return (
        <div className="px-4 pb-4 pt-2 border-2 border-green-dark rounded-[10px] bg-transparent">
            <h1 className="text-2xl text-green font-semibold pb-2">
                Tanks - 4/10
            </h1>
            <div className="flex max-w-full flex-wrap gap-y-6 justify-evenly gap-x-4">
            <Tank progress={40} />
            <Tank progress={40} />
            <Tank progress={40} />
            <Tank progress={40} />
            </div>
        </div>
    )
}

export default TankContainer

export type TankContainerProps = {
}