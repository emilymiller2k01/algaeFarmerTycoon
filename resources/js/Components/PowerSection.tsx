import React, {useEffect, useState} from 'react'
import GasSVG from "./Icons/GasSVG";
import PowerSVG from "./Icons/PowerSVG";
import SunSVG from "./Icons/SunSVG";
import WindSVG from "./Icons/WindSVG";
import {GameProps} from "../Pages/Game";
import { HomeProps } from '../Pages/Game'
import { router, usePage} from '@inertiajs/react';

const PowerSection = ({game, selectedFarmId, expanded = false}: PowerSectionProps) => {
    const { productionData, initialGame, researchTasks} = usePage<HomeProps>().props
    const [researchedRenewables, setResearchedRenewables] = useState(researchTasks.some(task => task.id === 10 && task.completed));
    const [researchedTechnologies, setResearchedTechnologies] = useState<string[]>([]);

    //TODO get rid of this useEffect 
    //pass through the props for the power enum 

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await fetch(`/research-tasks/completed/${game.id}`);
                if (!response.ok) {
                    throw new Error(`Network response was not ok: ${response.statusText}`);
                }
                const data = await response.json();

                // Assuming the server returns an array of researched technologies
                setResearchedTechnologies(data);
            } catch (error) {
                console.error("Error fetching researched technologies:", error);
            }
        };

        fetchData();
    }, [game.id]);

    return (
        <div className="p-4 flex border-2 border-green-dark rounded-[10px] gap-4 mr-auto">
            <div className="flex flex-col gap-4">
                <PowerSVG/>
                <p className="text-green font-semibold text-2xl">
                    Power
                </p>
            </div>
            {(expanded) &&
                <>
                    {researchedTechnologies.includes("renewable energies") && (
                        <>
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
                        </>
                    )}
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
                </>
            }
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

