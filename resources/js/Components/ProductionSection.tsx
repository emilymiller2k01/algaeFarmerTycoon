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
import { router, usePage } from '@inertiajs/react'
import { HomeProps } from '../Pages/Game'
import { useInterval } from '@mantine/hooks'


const ProductionSection = () => {

    const { productionData, initialGame } = usePage<HomeProps>().props

    const reloadData = () => {
        console.log('Prod data:');
        Object.keys(productionData).forEach(key => {
        console.log(`${key}: ${productionData[key]}`);
    });
        router.reload({
            only: ["productionData"]
        })
    }

    const { start, stop } = useInterval(reloadData, 1000)
    useEffect(() => {
        start()

        return stop
    }, [])

    return (
        <div className="flex flex-col">
            <div className="flex px-8 py-6 bg-grey justify-between font-semibold">
                <h1 className="text-2xl text-green">
                    Production
                </h1>
                <h2 className="text-2xl text-green">
                    MW {initialGame.mw}
                </h2>
            </div>
            <div className="flex justify-between text-xl text-yellow-dark">
                <p className="">$ Money</p>
                <p className="">{Number(productionData.currentMoney).toFixed(2)}</p>
                <p>{Number(productionData.moneyRate).toFixed(2)}</p>
            </div>

            <div className="flex justify-between text-xl text-green-dark">
                <p className="">
                    <AlgaeSVG className="inline-block -translate-y-[2px] p-[2px] stroke-green-dark" /> Algae Mass
                </p>
                <p className="">
                    {Number(productionData.algaeAmount || 0).toFixed(2)}
                </p>
                <p>
                    {Number(productionData.algaeRate || 0).toFixed(2)}
                </p>
            </div>
            <div className="flex justify-between text-xl text-yellow-dark">
                <p className="">
                    <BubblesSVG className="inline-block -translate-y-[2px]" /> CO2
                </p>
                <p className="">
                    {Number(productionData.co2Amount || 0).toFixed(2)}
                </p>
                <p>
                    {Number(productionData.co2Rate || 0).toFixed(2)}%
                </p>
            </div>
            <div className="flex justify-between text-xl text-green-dark">
                <p className="">
                    <TestTubeSVG className="inline-block -translate-y-[2px]" /> Nutrient Loss
                </p>
                <p>
                    {Number(productionData.nutrientsAmount).toFixed(2)}
                </p>
                <p className="">
                    {Number(productionData.nutrientsRate || 0).toFixed(2)}%
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
                    <TankSVG className="inline-block -translate-y-[2px] p-[2px]" /> Tanks
                    </p>
                    <p className="">
                        {productionData.tanks}/{Number(productionData.farms)*8} 
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
            <div className="flex justify-between text-xl text-green-dark">
                    <p className="">
                    <TempSVG className="inline-block -translate-y-[2px]" /> Temperature
                    </p>
                    <p className="">
                        {productionData.temperature}
                    </p>
                </div>
        </div>
    )
}

export default ProductionSection;
