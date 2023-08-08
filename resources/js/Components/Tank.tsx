import React from 'react'
import BasketSVG from "./Icons/BasketSVG";
import BubblesSVG from "./Icons/BubblesSVG";
import TestTubeSVG from "./Icons/TestTubeSVG";

const Tank = (props: TankProps) => {
    let { progress = 0 } = props;
    if (progress > 100) {
        progress = 100;
    } else if (progress < 0) {
        progress = 0;
    }

    return (
        <div className="relative">
            <div className="absolute top-[15px] left-0 p-2 flex flex-col justify-end h-[120px] w-[200px] gap-2 ">
                <div className="h-[17px] w-full rounded-full border overflow-hidden bg-grey-light border-green-dark">
                    <div className="h-full bg-green-dark " style={{ width: `${progress}%` }}></div>
                </div>
                <div className="flex justify-between gap-4">
                    <button className="border text-green-dark border-green-dark rounded-md hover:border-green hover:text-green py-2 h-[50px] w-[50px] aspect-square flex">
                        <BasketSVG className="m-auto pb-1" />
                    </button>
                    <button className="border text-green-dark border-green-dark rounded-md hover:border-green hover:text-green py-2 h-[50px] w-[50px] aspect-squar flex">
                        <TestTubeSVG className="m-auto" />
                    </button>
                    <button className="border text-green-dark border-green-dark rounded-md hover:border-green hover:text-green py-2 h-[50px] w-[50px] aspect-square flex">
                        <BubblesSVG className="m-auto" />
                    </button>
                </div>
            </div>
            <svg width="220" height="135" xmlns="http://www.w3.org/2000/svg">
                <polygon points="0,15 0,135 200,135 200,15" style={{ fill: "transparent", stroke: '#42FF00', strokeWidth: 2 }} />
                <line x1="0" y1="15" x2="20" y2="0" style={{ stroke: '#42FF00', strokeWidth: 2 }} />
                <line x1="200" y1="15" x2="220" y2="0" style={{ stroke: '#42FF00', strokeWidth: 2 }} />
                <line x1="200" y1="135" x2="220" y2="120" style={{ stroke: '#42FF00', strokeWidth: 2 }} />
                <line x1="20" y1="0" x2="220" y2="0" style={{ stroke: '#42FF00', strokeWidth: 2 }} />
                <line x1="220" y1="0" x2="220" y2="120" style={{ stroke: '#42FF00', strokeWidth: 2 }} />
            </svg>
        </div>
    )
}

export default Tank

export type TankProps = {
    progress?: number
}