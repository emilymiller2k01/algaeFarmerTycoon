
import React from 'react'
import BasketSVG from "./Icons/BasketSVG";
import BubblesSVG from "./Icons/BubblesSVG";
import TestTubeSVG from "./Icons/TestTubeSVG";
import TrashSVG from "./Icons/TrashSVG";

const AutomationSection = (props: AutomationSectionProps) => {
    return (
        <div className="px-4 pb-4 pt-2 border-2 border-green-dark rounded-[10px] bg-transparent">
            <h1 className="text-2xl text-green font-semibold pb-2">
                Automation
            </h1>
            <div className="flex w-full justify-between">
                <div className="flex flex-col border-2 p-2 w-32 border-green-dark rounded-md">
                    <TrashSVG className="mx-auto my-1" />
                    <p className="text-green-dark text-center font-semibold text-xl">
                        Waste Removal
                    </p>
                </div>
                <div className="flex flex-col border-2 p-2 w-32 border-green-dark rounded-md">
                    <TestTubeSVG className="mx-auto my-1" />
                    <p className="text-green-dark text-center font-semibold text-xl">
                        Nutrient Regulator
                    </p>
                </div>
                <div className="flex flex-col border-2 p-2 w-32 border-green-dark rounded-md">
                    <BubblesSVG className="mx-auto my-1" />
                    <p className="text-green-dark text-center font-semibold text-xl">
                        CO2 Regulator
                    </p>
                </div>
                <div className="flex flex-col border-2 p-2 w-32 border-green-dark rounded-md">
                    <BasketSVG className="mx-auto my-1" />
                    <p className="text-green-dark text-center font-semibold text-xl">
                        Automated Harvest
                    </p>
                </div>
            </div>
        </div>
    )
}

export default AutomationSection;

export type AutomationSectionProps = {
    expanded?: boolean
    solar?: number
    wind?: number
    gas?: number
}