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

    console.log(productionData);

    console.log(game.mw, productionData.currentMoney, productionData.moneyRate, productionData.algaeAmount, productionData.algaeRate)

    useEffect(() => {
        // Fetch initial data
        async function fetchData() {
            try {
                const response = await fetch(`/game/${game.id}/production`);
                const data = await response.json();
                if (data.success) {
                    setProductionData(data);
                }
            } catch (error) {
                console.error("There was an error fetching the production data:", error);
            }
        }

        fetchData();

        // Subscribe to WebSocket updates
        if (window.Echo) {
            window.Echo.private(`games.${game.id}`)
                .listen('.game.state.updated', (data) => {
                    console.log('Game state updated via WebSocket:', data);
                    setProductionData(data);
                });
        } else {
            console.error("Laravel Echo is not initialized!");
        }

        // Cleanup on component unmount
        return () => {
            window.Echo.leave(`games.${game.id}`);
        }
    }, [game.id]);

    return (
        <div className="flex flex-col">
            {/* ... [Rest of your JSX remains unchanged] ... */}

            <div className="flex justify-between text-xl text-green-dark">
                <p className="">
                    <DarkTestTubeSVG className="inline-block -translate-y-[2px] p-[2px] stroke-green-dark" /> Algae Mass
                </p>
                <p className="">
                    {productionData.algaeMass || 0}
                </p>
            </div>
            <div className="flex justify-between text-xl text-yellow-dark">
                <p className="">
                    <BubblesSVG className="inline-block -translate-y-[2px]" /> Algae Harvest
                </p>
                <p className="">
                    {productionData.algaeHarvest || 0}
                </p>
            </div>
            <div className="flex justify-between text-xl text-green-dark">
                <p className="">
                    <TestTubeSVG className="inline-block -translate-y-[2px]" /> Nutrient Loss
                </p>
                <p className="">
                    {productionData.nutrientLoss || 0}%
                </p>
            </div>
            <div className="flex justify-between text-xl text-yellow-dark">
                <p className="">
                    <LightSVG className="inline-block -translate-y-[2px] p-[2px]" /> Lux
                </p>
                <p className="">
                    {productionData.lux || 0}
                </p>
            </div>

            {/* ... [Rest of your JSX remains unchanged] ... */}
        </div>
    )
}

type ProductionData = {
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

export type ProductionProps = {
    game: Game;
}

export default ProductionSection;
