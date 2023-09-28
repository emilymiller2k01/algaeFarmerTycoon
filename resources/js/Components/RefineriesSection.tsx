import React, { useState } from 'react';
import BasketSVG from "./Icons/BasketSVG";
import BubblesSVG from "./Icons/BubblesSVG";
import RefinarySVG from "./Icons/RefinarySVG";
import SettingsSVG from "./Icons/SettingsSVG";
import TestTubeSVG from "./Icons/TestTubeSVG";
import TrashSVG from "./Icons/TrashSVG";
import { GameProps, Produce, HomeProps, ResearchTask } from "../Pages/Game";
import { usePage } from "@inertiajs/react";
import { PageProps } from '../types';
import { useDisclosure } from '@mantine/hooks';
import { Modal, Button } from '@mantine/core';
import RefineryPopUp from './tooltips/refineryPopUp';

const RefineriesSection = () => {
    const { refineries, researchTasks } = usePage<PageProps<HomeProps>>().props;
    const [isPopupOpen, setPopupOpen] = useState(false);

    // Check if the "Algae By-products" task has been completed
    const isAlgaeByProductsCompleted = researchTasks.find(task => task.title === 'Algae By-products')?.completed || false;

    const displayModal = () => {
        setPopupOpen(!isPopupOpen);
    }

    return (
        <div className="px-4 pb-4 pt-2 border-2 border-green-dark rounded-[10px] bg-transparent">
            <div className="flex items-center justify-between">
                <h1 className="text-2xl text-green font-semibold pb-2">
                    Refineries
                </h1>
                {isAlgaeByProductsCompleted && (
                    <Button
                        onClick={() => displayModal()}
                        className="border-2 border-green-dark rounded-md flex flex-col"
                    >
                        <SettingsSVG className="my-auto mx-3" />
                    </Button>
                )}
            </div>
            <div className="flex w-full flex-wrap gap-y-6 justify-evenly gap-x-4">
                {Array.isArray(refineries) && refineries.map(refinery => (
                    <RefineryComponent key={refinery.id} {...refinery} />
                ))}
            </div>
            {isPopupOpen && <RefineryPopUp show={isPopupOpen} handleClose={displayModal} />}
        </div>
    );
};

const RefineryComponent = ({ id, produce, mw }: Refinery) => {
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
    mw: number;
}
