import React from 'react'
import BasketSVG from "./Icons/BasketSVG";
import BubblesSVG from "./Icons/BubblesSVG";
import RefinarySVG from "./Icons/RefinarySVG";
import SettingsSVG from "./Icons/SettingsSVG";
import TestTubeSVG from "./Icons/TestTubeSVG";
import TrashSVG from "./Icons/TrashSVG";

const RefineriesSection = (props: RefineriesSectionProps) => {
    return (
        <div className="px-4 pb-4 pt-2 border-2 border-green-dark rounded-[10px] bg-transparent">
            <h1 className="text-2xl text-green font-semibold pb-2">
                Refineries
            </h1>
            <div className="flex w-full justify-between">
                <div className="flex flex-col border-2 border-green-dark rounded-md">
                    <RefinarySVG className="mx-auto" />
                </div>
                <div className="flex flex-col border-2 border-green-dark rounded-md">
                    <RefinarySVG className="mx-auto" />
                </div>
                <div className="flex flex-col border-2 border-green-dark rounded-md">
                    <RefinarySVG className="mx-auto" />
                </div>
                <div className="flex flex-col border-2 border-green-dark rounded-md">
                    <RefinarySVG className="mx-auto" />
                </div>
                <div className="flex flex-col border-2 border-green-dark rounded-md">
                    <SettingsSVG className="my-auto mx-3 " />
                </div>
            </div>
        </div>
    )
}

export default RefineriesSection;

export type RefineriesSectionProps = {
    expanded?: boolean
    solar?: number
    wind?: number
    gas?: number
}