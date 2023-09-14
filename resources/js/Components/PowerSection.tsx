import React, { useContext, useEffect, useMemo, useState } from 'react';
import GasSVG from "./Icons/GasSVG";
import PowerSVG from "./Icons/PowerSVG";
import SunSVG from "./Icons/SunSVG";
import WindSVG from "./Icons/WindSVG";
import { GameProps } from "../Pages/Game";
import { HomeProps } from '../Pages/Game'
import { router, usePage } from '@inertiajs/react';
import { Power } from '../types';
import { PowerTypes} from '../types';
import { PowerContext } from '../PowerContext';

const PowerSection = ({ game, selectedFarmId, expanded = false }: PowerSectionProps) => {
    const { productionData, initialGame, researchTasks, powers} = usePage<HomeProps>().props;
    const [researchedTechnologies, setResearchedTechnologies] = useState<string[]>([]);

    const solar = useMemo(() => powers.find((power) => power.type === "solar") || 0, [powers]);
    const wind = powers.find((power) => power.type === "wind") || 0;
    const gas = powers.find((power) => power.type === 'gas') || 0;
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
            }
        })
    };

    return (
        <div className="flex flex-col gap-4 w-full">
            <div className="p-4 flex border-2 border-green-dark rounded-[10px] gap-4">
                <div className="flex flex-col gap-4">
                    <PowerSVG />
                    <p className="text-green font-semibold text-2xl">
                        Power
                    </p>
                </div>
                {isTask5Completed && (
                    <div className="flex flex-wrap gap-4 flex-grow">
                        <button onClick={() => { purchaseEnergy("solar") }} className="flex-grow">
                            <div
                                className="flex flex-col gap-1 border px-3 py-1 border-green-dark rounded-lg w-[148px]">
                                <div className="flex w-full justify-between">
                                    <p className="text-green font-semibold text-2xl">
                                        Solar
                                    </p>
                                    <p className="text-green font-semibold text-2xl">
                                        solar
                                    </p>
                                </div>
                                <SunSVG className="mx-auto" />
                            </div>
                        </button>
                        <button onClick={() => { purchaseEnergy("wind") }} className="flex-grow">
                            <div
                                className="flex flex-col gap-1 border px-3 py-1 border-green-dark rounded-lg w-[148px]">
                                <div className="flex w-full justify-between">
                                    <p className="text-green font-semibold text-2xl">
                                        Wind
                                    </p>
                                    <p className="text-green font-semibold text-2xl">
                                        wind
                                    </p>
                                </div>
                                <WindSVG className="mx-auto" />
                            </div>
                        </button>
                        <button onClick={() => { purchaseEnergy("gas") }} className="flex-grow">
                            <div
                                className="flex flex-col gap-1 border px-3 py-1 border-green-dark rounded-lg w-[148px]">
                                <div className="flex w-full justify-between">
                                    <p className="text-green font-semibold text-2xl">
                                        Gas
                                    </p>
                                    <p className="text-green font-semibold text-2xl">
                                        gas
                                    </p>
                                </div>
                                <GasSVG className="mx-auto" />
                            </div>
                        </button>
                    </div>
                )}
            </div>
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
