import React from 'react'
import AlgaeSVG from "./Icons/AlgaeSVG"
import BubblesSVG from "./Icons/BubblesSVG"
import DarkTestTubeSVG from "./Icons/DarkTestTubeSVG"
import FarmSVG from "./Icons/FarmSVG"
import LightSVG from "./Icons/LightSVG"
import TankSVG from "./Icons/TankSVG"
import TempSVG from "./Icons/TempSVG"
import TestTubeSVG from "./Icons/TestTubeSVG"
import YellowBubblesSVG from "./Icons/YellowBubbles"

const ProductionSection = (props: ProductionProps) => {
    return (
        <div className="flex flex-col">
            <div className="flex px-8 py-6 bg-grey justify-between font-semibold">
                <h1 className="text-2xl text-green">
                    Production
                </h1>
                <h2 className="text-2xl text-green">
                    {props.powerOutput}
                </h2>
            </div>
            <div className="flex flex-col px-8 py-6 gap-4 font-semibold">
                <div className="flex justify-between text-xl text-green-dark">
                    <p className="">
                       $ Money
                    </p>
                    <p className="">
                        {props.moneyAmount}
                    </p>
                    <p>
                        {props.moneyRate}
                    </p>
                </div>
                <div className="flex justify-between text-xl text-yellow-dark">
                    <p className="">
                       <AlgaeSVG className="inline-block -translate-y-[2px]" /> Algae
                    </p>
                    <p className="">
                        {props.algaeAmount}
                    </p>
                    <p className="">
                        {props.algaeRate}
                    </p>
                </div>
                <div className="flex justify-between text-xl text-green-dark">
                    <p className="">
                    <TankSVG className="inline-block -translate-y-[2px] p-[2px]" /> Tanks
                    </p>
                    <p className="">
                        {props.tanks}
                    </p>
                </div>
                <div className="flex justify-between text-xl text-yellow-dark">
                    <p className="">
                    <FarmSVG className="inline-block -translate-y-[2px] p-[2px]" /> Farms
                    </p>
                    <p className="">
                        {props.farms}
                    </p>
                </div>
                <div className="flex justify-between text-xl text-green-dark">
                    <p className="">
                    <DarkTestTubeSVG className="inline-block -translate-y-[2px] p-[2px] stroke-green-dark" /> Nutrients
                    </p>
                    <p className="">
                        {props.nutrientsAmount}
                    </p>
                    <p className="">
                        {props.nutrientsRate}
                    </p>
                </div>
                <div className="flex justify-between text-xl text-yellow-dark">
                    <p className="">
                    <YellowBubblesSVG className="inline-block -translate-y-[2px] p-[2px]" /> CO2
                    </p>
                    <p className="">
                        {props.co2Amount}
                    </p>
                    <p className="">
                        {props.co2Rate}
                    </p>
                </div>
                <div className="flex justify-between text-xl text-green-dark">
                    <p className="">
                    <TempSVG className="inline-block -translate-y-[2px]" /> Temperature
                    </p>
                    <p className="">
                        {props.temperature}
                    </p>
                </div>
                <div className="flex justify-between text-xl text-yellow-dark">
                    <p className="">
                    <LightSVG className="inline-block -translate-y-[2px] p-[2px]" /> Light
                    </p>
                    <p className="">
                        {props.light}
                    </p>
                </div>


            </div>
        </div>
    )
}

export default ProductionSection

export type ProductionProps = {
    powerOutput: string,
    moneyAmount: string,
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
}