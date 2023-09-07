import React from 'react'
import BasketSVG from "./Icons/BasketSVG";
import BubblesSVG from "./Icons/BubblesSVG";
import RefinarySVG from "./Icons/RefinarySVG";
import SettingsSVG from "./Icons/SettingsSVG";
import TestTubeSVG from "./Icons/TestTubeSVG";
import TrashSVG from "./Icons/TrashSVG";
import {GameProps, Produce, HomeProps} from "../Pages/Game";
import {router, usePage} from "@inertiajs/react";
import { PageProps } from '../types';

const RefineriesSection = ({ game, selectedFarmId } : RefineriesSectionProps) => {
    const {refineries} = usePage<{refineries:Refinery[]}>().props

    console.log('props', usePage().props); // Log the entire props object
    console.log('refineries', refineries);

    return (
        <div className="px-4 pb-4 pt-2 border-2 border-green-dark rounded-[10px] bg-transparent">
            <h1 className="text-2xl text-green font-semibold pb-2">
                Refineries
            </h1>
            <div className="flex w-full justify-between">
                <div className="flex max-w-full flex-wrap gap-y-6 justify-evenly gap-x-4">
                    {Array.isArray(refineries) && refineries.map(refinery => (
                        <RefineryComponent key={refinery.id} {...refinery} />
                    ))}
                </div>
            
                <div className="flex flex-col border-2 border-green-dark rounded-md">
                    <SettingsSVG className="my-auto mx-3 " />
                </div>
            </div>
        </div>
    )
};

const RefineryComponent = ({ id, produce, mw }) => {
    return (
        <div className="flex flex-col border-2 border-green-dark rounded-md">
            <RefinarySVG className="mx-auto" />
        </div>
    );
};

export default RefineriesSection;

type Refinery = {
    id: number;
    produce: Produce;
    mw: Number;
}

export type RefineriesSectionProps = {
    game: GameProps;
    selectedFarmId: number;
}
