import React, {useEffect, useState} from 'react'
import GasSVG from "./Icons/GasSVG";
import PowerSVG from "./Icons/PowerSVG";
import SunSVG from "./Icons/SunSVG";
import WindSVG from "./Icons/WindSVG";
import {GameProps} from "../Pages/Game";
import { HomeProps } from '../Pages/Game'
import { router, usePage} from '@inertiajs/react';
import { PowerTypes } from '../Pages/Game';
import { type } from 'os';

const PowerSection = ({game, selectedFarmId, expanded = false}: PowerSectionProps) => {
    const { productionData, initialGame, researchTasks, powers} = usePage<HomeProps>().props
    const [researchedTechnologies, setResearchedTechnologies] = useState<string[]>([]);

    const solar = powers.find((power) => power.type === PowerTypes.solar)?.mw || 0;
    const wind = powers.find((power) => power.type === PowerTypes.wind)?.mw || 0;
    const gas = powers.find((power) => power.type === PowerTypes.gas)?.mw || 0;
    const isTask5Completed = calculateIsTask5Completed(researchTasks);

    function calculateIsTask5Completed(researchTasks) {
        // Find the "Renewable Energies" task by name
        const task5 = researchTasks.find((task) => task.title === 'Renewable Energies');
    
        // Check if task 5 exists and is complete

        return task5 ? task5.completed : false;
      }

    const purchaseEnergy = (powerType: string) => {
        router.post(`/game/${initialGame.id}/farm/${initialGame.selected_farm_id}/purchaseEnergy`, {
            type: powerType,
        }, {
            onSuccess: () => {
                router.reload({ only: ['MultiSection', 'ProductionSection'] });
            }})
    };

    return (
        <div className="p-4 flex border-2 border-green-dark rounded-[10px] gap-4 mr-auto">
            <div className="flex flex-col gap-4">
                <PowerSVG/>
                <p className="text-green font-semibold text-2xl">
                    Power
                </p>
            </div>
                {isTask5Completed && (
                    <div>
                    <button onClick={() => {purchaseEnergy("solar")}}>
                        <div
                            className="flex flex-col gap-1 border px-3 py-1 border-green-dark rounded-lg w-[148px]">
                            <div className="flex w-full justify-between">
                                <p className="text-green font-semibold text-2xl">
                                    Solar
                                </p>
                                <p className="text-green font-semibold text-2xl">
                                    {solar}
                                </p>
                            </div>
                            <SunSVG className="mx-auto"/>
                        </div>
                    </button>
                    <button onClick={() => {purchaseEnergy("wind")}}>
                        <div
                            className="flex flex-col gap-1 border px-3 py-1 border-green-dark rounded-lg w-[148px]">
                            <div className="flex w-full justify-between">
                                <p className="text-green font-semibold text-2xl">
                                    Wind
                                </p>
                                <p className="text-green font-semibold text-2xl">
                                    {wind}
                                </p>
                            </div>
                            <WindSVG className="mx-auto"/>
                        </div>
                    </button>
                    </div>
                )}
            <button onClick={() => {purchaseEnergy("gas")}}>
                <div className="flex flex-col gap-1 border px-3 py-1 border-green-dark rounded-lg w-[148px]">
                    <div className="flex w-full justify-between">
                        <p className="text-green font-semibold text-2xl">
                            Gas
                        </p>
                        <p className="text-green font-semibold text-2xl">
                            {gas}
                        </p>
                    </div>
                    <GasSVG className="mx-auto"/>
                </div>
            </button>
        </div>
    )
}

export default PowerSection;

export type PowerSectionProps = {
    game: GameProps,
    selectedFarmId: number,
    expanded?: boolean,
    wind?: number,
    solar?: number,
    gas?: number
}

