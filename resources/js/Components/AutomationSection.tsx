
import React from 'react'
import BasketSVG from "./Icons/BasketSVG";
import BubblesSVG from "./Icons/BubblesSVG";
import TestTubeSVG from "./Icons/TestTubeSVG";
import TrashSVG from "./Icons/TrashSVG";
import {GameProps, ResearchTask} from "../Pages/Game";

const AutomationSection = (props: AutomationSectionProps) => {
    const gameId = props.game.id;  // Extract game ID from the game prop
    const researchTasks = props.tasks;

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
                {researchTasks.some(task => task.title === 'Automated Nutrient Management' && task.automation) && (
                    <div className="flex flex-col border-2 p-2 w-32 border-green-dark rounded-md">
                        <TestTubeSVG className="mx-auto my-1" />
                        <p className="text-green-dark text-center font-semibold text-xl">
                            Nutrient Regulator
                        </p>
                    </div>
                )}
                {researchTasks.some(task => task.title === 'CO2 Management System' && task.automation) && (
                    <div className="flex flex-col border-2 p-2 w-32 border-green-dark rounded-md">
                        <BubblesSVG className="mx-auto my-1" />
                        <p className="text-green-dark text-center font-semibold text-xl">
                            CO2 Regulator
                        </p>
                    </div>
                )}
                {researchTasks.some(task => task.title === 'Automated Harvesting System' && task.automation) && (
                    <div className="flex flex-col border-2 p-2 w-32 border-green-dark rounded-md">
                        <BasketSVG className="mx-auto my-1" />
                        <p className="text-green-dark text-center font-semibold text-xl">
                            Automated Harvest
                        </p>
                    </div>
                )}
            </div>
        </div>
    )
}


export default AutomationSection;

export type AutomationSectionProps = {
    game: GameProps;
    expanded?: boolean;
    tasks: ResearchTask[];
}
