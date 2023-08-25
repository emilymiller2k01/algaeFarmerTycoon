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
                <div className="h-[17px] w-full rounded-full border overflow-hidden bg-grey-light border-green-dark text-green">
                    <div className="h-full bg-green-dark " style={{ width: `${10}%` }}> Biomass </div>
                </div>
                <div className="h-[17px] w-full rounded-full border overflow-hidden bg-grey-light border-green-dark text-green">
                    <div className="h-full bg-yellow " style={{ width: `${10}%` }}> Nutrients </div>
                </div>
                <div className="h-[17px] w-full rounded-full border overflow-hidden bg-grey-light border-green-dark text-green items-center ">
                    <div className="h-full bg-orange" style={{ width: `${10}%`, padding: '0 5px' }}>
                        CO2
                    </div>
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