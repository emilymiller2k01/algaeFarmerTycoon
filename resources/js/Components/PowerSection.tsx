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

const PowerSection = () => {
    const { productionData, initialGame, researchTasks, powers } = usePage<HomeProps>().props;
    const [researchedTechnologies, setResearchedTechnologies] = useState<string[]>([]);

    // Define isTask5Completed here
    const isTask5Completed = researchTasks.find(task => task.title === 'Renewable Energies')?.completed || false;

    const solar = useMemo(() => powers.filter((power) => power.type === "solar").length, [powers]);
    const wind = useMemo(() => powers.filter((power) => power.type === "wind").length, [powers]);
    const gas = useMemo(() => powers.filter((power) => power.type === 'gas').length, [powers]);

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
                <button onClick={() => { purchaseEnergy("gas") }} className="flex-grow">
                    <div
                        className="flex flex-col gap-1 border px-3 py-1 border-green-dark rounded-lg w-[148px]">
                        <div className="flex w-full justify-between">
                            <p className="text-green font-semibold text-2xl">
                                Gas
                            </p>
                            <p className="text-green font-semibold text-2xl">
                                {gas}
                            </p>
                        </div>
                        <GasSVG className="mx-auto" />
                    </div>
                </button>
                {isTask5Completed && (
                    <div className="flex flex-wrap gap-4 flex-grow">
                        <button onClick={() => { purchaseEnergy("solar") }} className="flex-grow">
                        <div className="flex flex-col gap-1 border px-3 py-1 border-green-dark rounded-lg w-[148px]">
                            <div className="flex w-full justify-between">
                            <p className="text-green font-semibold text-2xl">
                                Solar
                            </p>
                            <p className="text-green font-semibold text-2xl">
                                {solar}
                            </p>
                            </div>
                            <SunSVG className="mx-auto" />
                        </div>
                        </button>
                        <button onClick={() => { purchaseEnergy("wind") }} className="flex-grow">
                        <div className="flex flex-col gap-1 border px-3 py-1 border-green-dark rounded-lg w-[148px]">
                            <div className="flex w-full justify-between">
                            <p className="text-green font-semibold text-2xl">
                                Wind
                            </p>
                            <p className="text-green font-semibold text-2xl">
                                {wind}
                            </p>
                            </div>
                            <WindSVG className="mx-auto" />
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
