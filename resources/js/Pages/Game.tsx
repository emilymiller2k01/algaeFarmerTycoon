import React, {useState} from 'react';
import '../../css/app.css';
import ExpansionsSection from '../Components/ExpansionsSection';
import FarmsSection from '../Components/FarmsSection';
import LogSection from '../Components/LogSection';
import MultiSection from '../Components/MultiSection';
import ProductionSection from '../Components/ProductionSection';
import { logs, production } from '../data/props';
//import {Tank} from "@/types";
import { usePage } from '@inertiajs/react';
import { PageProps, Tank } from '../types';
import { Power } from '../types';

export type GameProps = {
    id: number;
    name: string;
    user_id: number;
    mw: number;
    money: number;
    mw_cost: number;
    selected_farm_id: number;
}


export enum Produce{
    biofuel, 
    antioxidants,
    fertiliser,
    food,
}

export type Refinery = {
    id: number
    produce: Produce;
    mw: number
}

export type Farm = {
    id: number;
    tanks: Tank[];
    mw: number;
}


export type ProductionData = {
    success?: boolean;
    currentMoney?: number;
    farmData?: Array<any>;
    totalFarms?: number;
    totalTanks?: number;
    totalLux?: number;
    gameId: number;
    powerOutput: string,
    moneyRate: string,
    algaeAmount: string,
    algaeRate: string,
    algaeMass: number,
    algaeHarvest: number,
    tanks: string,
    farms: string,
    nutrientsAmount: string,
    nutrientsRate: string,
    nutrientLoss: number,
    co2Amount: string,
    co2Rate: string,
    temperature: string,
    light: string,
    lux: number,
};

export type ResearchTask = {
    id: number,
    title: string,
    task: string,
    completed: boolean,
    automation: boolean,
    cost: number,
    mw: number,
}

export type HomeProps = {
    initialGame: GameProps;
    tanks: Tank[];
    farms: Farm[];
    productionData: ProductionData;
    researchTasks: ResearchTask[];
    refineries: Refinery[];
    powers: Power[];
}

function Home() {

    const {initialGame, tanks, farms, researchTasks, refineries, powers} = usePage<PageProps<HomeProps>>().props;

    const [game, setGame] = useState(initialGame);
    console.log('refineries', refineries);

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
                        <ProductionSection />
                    </div>
                    <div className="h-[40vh]">
                        <ExpansionsSection />
                    </div>
                </div>
                <div className="flex flex-col w-1/2 h-full border-x-2 border-x-green">
                    <MultiSection />
                </div>
                <div className="flex flex-col w-1/4 h-full">
                    <div className="h-[45vh]">
                        <FarmsSection updateSelectedFarm={updateSelectedFarmId} />
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
