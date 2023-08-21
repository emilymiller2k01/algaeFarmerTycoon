import React, {useState} from 'react'
import ExpansionButton from "./ExpansionButton"
import game, { GameProps } from "../Pages/Game";
import { InertiaLink } from '@inertiajs/inertia-react'
import {router} from "@inertiajs/react";
import axios from "axios";

const ExpansionsSection = (props: ExpansionsProps) => {

    //const hasResearchedRefinery = props.game.id.researchTasks.some(task => task.name === "Refinery");
    const [tanks, setTanks] = useState([]);


    const addFarm = () => {
        router.post(`/game/${props.game.id}/farm/${props.game.selected_farm_id}/addFarm`, {}, {
            onSuccess: () => {
                router.reload({ only: ['MultiSection', 'FarmSelection'] });
            }})

    };

    const addLight = (lightType: string) => {
        router.post(`/game/${props.game.id}/farm/${props.game.selected_farm_id}/light}`, {
            lightType: lightType, // assuming the title is the type of light you want to add
        }, {
            onSuccess: () => {
                router.reload({ only: ['ProductionSection'] });
            }
        });
    };

    const addFarmCo2 = () => {
        router.post(`/game/${props.game.id}/farm/${props.game.selected_farm_id}/farmCo2`, {});
    };

    const addFarmNutrients = () => {
        router.post(`/game/${props.game.id}/farm/${props.game.selected_farm_id}/farmNutrients`, {});
    };


    const addFarmTank = () => {
        router.post(`/game/${props.game.id}/farm/${props.game.selected_farm_id}/addTank`, {},{
            onSuccess: () => {
                // Refresh only the parts of your UI you need to. In this case, we're assuming you have a 'TankSection'.
                router.reload({ only: ['TankContainer'] });
            }
        });
    }

    const addFarmRefinery = () => {
        router.post(`/game/${props.game.id}/farm/${props.game.selected_farm_id}/refinery`, {});
    };

    return (
        <div className="flex flex-col h-full">
            <div className="flex px-8 py-6 bg-grey items-start">
                <h1 className="text-2xl text-green font-semibold">
                    Expansions
                </h1>
            </div>
            <div className="flex flex-grow flex-col overflow-y-scroll">
                <div className="grid grid-cols-2 gap-y-[10px] gap-x-4 p-4">
                    <ExpansionButton title={"Florescent"} onClick={() => { addLight("Florescent")}}/>
                    <ExpansionButton title={"LED"} onClick={() => { addLight("LED") }}/>
                    {/*{props.game.researchedRefineries &&*/}
                    <ExpansionButton title={"Refinery"} onClick={() => { addFarmRefinery() }}/>
                    <ExpansionButton title={"Farm"} onClick={() => { addFarm() }}/>
                    <ExpansionButton title={"CO2"} onClick={() => { addFarmCo2() }}/>
                    <ExpansionButton title={"Nutrients"} onClick={() => { addFarmNutrients() }}/>
                    <ExpansionButton title={"Tank"} onClick={() => { addFarmTank() }}/>
                </div>
                <div className="flex justify-between p-4">
                    <InertiaLink href={`/decrementTemperature/${props.game.selected_farm_id}/${props.game.id}`} className="px-4 py-2 bg-red-600 text-white rounded-lg">
                        Decrease Temperature
                    </InertiaLink>
                    <InertiaLink href={`/incrementTemperature/${props.game.selected_farm_id}/${props.game.id}`} className="px-4 py-2 bg-green-600 text-white rounded-lg">
                        Increase Temperature
                    </InertiaLink>
                </div>
            </div>
        </div>
    )
}



export default ExpansionsSection

export type ExpansionsProps = {
    game: GameProps;
}
