import React, {useEffect, useState} from 'react'
import AlgaeSVG from "./Icons/AlgaeSVG"
import BubblesSVG from "./Icons/BubblesSVG"
import DarkTestTubeSVG from "./Icons/DarkTestTubeSVG"
import FarmSVG from "./Icons/FarmSVG"
import LightSVG from "./Icons/LightSVG"
import TankSVG from "./Icons/TankSVG"
import TempSVG from "./Icons/TempSVG"
import TestTubeSVG from "./Icons/TestTubeSVG"
import YellowBubblesSVG from "./Icons/YellowBubbles"

type Game = {
    id: number;
    name: string;
    user_id: number;
    mw: string;
    money: string;
    mw_cost: string;
    selected_farm_id: number;
};

const ProductionSection = ({ game }: ProductionProps) => {
    const [productionData, setProductionData] = useState<ProductionData>({} as ProductionData);
    useEffect(() => {
        async function fetchData() {
            try {
                const response = await fetch(`/api/production/${productionData.gameId}`);
                const data = await response.json();
                if (data.success) {
                    setProductionData(data);
                }
            } catch (error) {
                console.error("There was an error fetching the production data:", error);
            }
        }
        fetchData();
    }, [game.id]);

    return (
        <div className="flex flex-col">
            <div className="flex px-8 py-6 bg-grey justify-between font-semibold">
                <h1 className="text-2xl text-green">
                    Production
                </h1>
                <h2 className="text-2xl text-green">
                    {game.mw}
                </h2>
            </div>
            <div className="flex flex-col px-8 py-6 gap-4 font-semibold">
                <div className="flex justify-between text-xl text-green-dark">
                    <p className="">
                       $ Money
                    </p>
                    <p className="">
                        {productionData.currentMoney  || 0}
                    </p>
                    <p>
                        {productionData.moneyRate}
                    </p>
                </div>
                <div className="flex justify-between text-xl text-yellow-dark">
                    <p className="">
                       <AlgaeSVG className="inline-block -translate-y-[2px]" /> Algae
                    </p>
                    <p className="">
                        {productionData.algaeAmount}
                    </p>
                    <p className="">
                        {productionData.algaeRate}
                    </p>
                </div>
                <div className="flex justify-between text-xl text-green-dark">
                    <p className="">
                    <TankSVG className="inline-block -translate-y-[2px] p-[2px]" /> Tanks
                    </p>
                    <p className="">
                        {productionData.tanks}
                    </p>
                </div>
                <div className="flex justify-between text-xl text-yellow-dark">
                    <p className="">
                    <FarmSVG className="inline-block -translate-y-[2px] p-[2px]" /> Farms
                    </p>
                    <p className="">
                        {productionData.farms}
                    </p>
                </div>
                <div className="flex justify-between text-xl text-green-dark">
                    <p className="">
                    <DarkTestTubeSVG className="inline-block -translate-y-[2px] p-[2px] stroke-green-dark" /> Nutrients
                    </p>
                    <p className="">
                        {productionData.nutrientsAmount}
                    </p>
                    <p className="">
                        {productionData.nutrientsRate}
                    </p>
                </div>
                <div className="flex justify-between text-xl text-yellow-dark">
                    <p className="">
                    <YellowBubblesSVG className="inline-block -translate-y-[2px] p-[2px]" /> CO2
                    </p>
                    <p className="">
                        {productionData.co2Amount}
                    </p>
                    <p className="">
                        {productionData.co2Rate}
                    </p>
                </div>
                <div className="flex justify-between text-xl text-green-dark">
                    <p className="">
                    <TempSVG className="inline-block -translate-y-[2px]" /> Temperature
                    </p>
                    <p className="">
                        {productionData.temperature}
                    </p>
                </div>
                <div className="flex justify-between text-xl text-yellow-dark">
                    <p className="">
                    <LightSVG className="inline-block -translate-y-[2px] p-[2px]" /> Light
                    </p>
                    <p className="">
                        {productionData.light}
                    </p>
                </div>


            </div>
        </div>
    )
}



export default ProductionSection;

type ProductionData = {
    success?: boolean;
    currentMoney?: number;
    farmData?: Array<any>; // or a more specific type if you have one
    totalFarms?: number;
    totalTanks?: number;
    totalLux?: number;
    gameId: number;
    powerOutput: string,
    moneyRate: string,
    algaeAmount: string,
    algaeRate: string,
    tanks: string,
    farms: string,
    nutrientsAmount: string,
    nutrientsRate: string,
    co2Amount: string,
    co2Rate: string,
    temperature: string,
    light: string,
};

export type ProductionProps = {
    game: Game;

}
