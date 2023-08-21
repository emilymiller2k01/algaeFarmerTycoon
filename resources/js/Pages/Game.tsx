import React, {useState} from 'react';
import '../../css/app.css';
import ExpansionsSection from '../Components/ExpansionsSection';
import FarmsSection from '../Components/FarmsSection';
import LogSection from '../Components/LogSection';
import MultiSection from '../Components/MultiSection';
import ProductionSection from '../Components/ProductionSection';
import { logs, production } from '../data/props';
//import {Tank} from "@/types";
import { InertiaApp } from '@inertiajs/inertia-react';

export type GameProps = {
    id: number;
    name: string;
    user_id: number;
    mw: number;
    money: number;
    mw_cost: number;
    selected_farm_id: number;
}

export type Tank = {
    farm_id: number
    nutrient_level: number
    co2_level: number
    biomass: number
    mw: number
}

export type Farm = {
    id: number;
    tanks: Tank[];
    mw: number;
}

type HomeProps = {
    initialGame: GameProps;
    tanks: Tank[];
    farms: Farm[];
}

function Home ({initialGame, tanks, farms}: HomeProps){

    const [game, setGame] = useState(initialGame);
    console.log(tanks)
    console.log("famrs:", farms)

    // This function will be passed to FarmSection to update the selected_farm_id
    const updateSelectedFarmId = (newId) => {
       const updatedGame = { ...game, selected_farm_id: newId };
       setGame(updatedGame);
    }

    return (
        <main className="flex min-h-screen max-h-screen min-w-full overflow-hidden max-w-full bg-grey-dark">
            <div className="flex w-full min-h-full">
                <div className="flex flex-col w-1/4 h-full">
                    <div className="h-[60vh]">
                        <ProductionSection game={game} {...production} />
                    </div>
                    <div className="h-[40vh]">
                        <ExpansionsSection game={game} />
                    </div>
                </div>
                <div className="flex flex-col w-1/2 h-full border-x-2 border-x-green">
                    <MultiSection game={game}  selectedFarmId={game.selected_farm_id}/>
                </div>
                <div className="flex flex-col w-1/4 h-full">
                    <div className="h-[45vh]">
                        <FarmsSection game={game} selectedFarmId={game.selected_farm_id} updateSelectedFarm={updateSelectedFarmId} />
                    </div>
                    <div className="h-[55vh]">
                        <LogSection {...logs} />
                    </div>
                </div>
            </div>
        </main>
    )
};

export default Home;
