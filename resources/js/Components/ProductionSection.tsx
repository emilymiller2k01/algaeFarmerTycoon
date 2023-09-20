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
import { HomeProps, ProductionData } from '../Pages/Game'
import { useInterval } from '@mantine/hooks'
import { PageProps } from '../types'

const ProductionSection = () => {

    const {productionData, initialGame} = usePage<PageProps<HomeProps>>().props;

    const [data, setData] = useState<ProductionData>(productionData);

    console.log(data, initialGame);

    const reloadData = async () => {
      try {
        //here need to run get production data helper to reload every second 
        fetch(`/game/${initialGame.id}/production-data`).then((response) => {
            response.json().then(({productionData: newData}) => {
                setData(newData);
            })
        });
        
      } catch (error) {
        console.error('Error fetching production data:', error);
      }
    };
      
    const { start, stop } = useInterval(reloadData, 1000);
  
    useEffect(() => {
      start();
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
            <div className="flex px-8 py-6 bg-grey justify-between font-semibold">
                <h1 className="text-xl text-green">
                    
                </h1>
                <h2 className="text-xl text-green">
                    Amount 
                </h2>
                <h2 className="text-xl text-green">
                    Rate
                </h2>
            </div>
            <div className="flex justify-between text-xl text-yellow-dark">
                <p className="">$ Money</p>
                <p className="">{Number(initialGame.money).toFixed(2)}</p>
                <p>{Number(data.moneyRate).toFixed(2)}</p>
            </div>

            <div className="flex justify-between text-xl text-green-dark">
                <p className="">
                    <AlgaeSVG className="inline-block -translate-y-[2px] p-[2px]" /> Algae Mass
                </p>
                <p className="">
                    {Number(data.algaeMass || 0).toFixed(2)}
                </p>
                <p>
                    {Number(data.algaeRate || 0).toFixed(2)}
                </p>
            </div>
            <div className="flex justify-between text-xl text-yellow-dark">
                <p className="">
                    <BubblesSVG className="inline-block -translate-y-[2px]" /> CO2
                </p>
                <p className="">
                    {Number(data.co2Amount || 0).toFixed(2)}%
                </p>
                <p>
                    {Number(data.co2Rate || 0).toFixed(2)}%
                </p>
            </div>
            <div className="flex justify-between text-xl text-green-dark">
                <p className="">
                    <TestTubeSVG className="inline-block -translate-y-[2px]" /> Nutrient 
                </p>
                <p>
                    {Number(data.nutrientsAmount).toFixed(2)}%
                </p>
                <p className="">
                    {Number(data.nutrientsRate || 0).toFixed(2)}%
                </p>

            </div>
            <div className="flex justify-between text-xl text-yellow-dark">
                    <p className="">
                    <FarmSVG className="inline-block -translate-y-[2px] p-[2px]" /> Farms
                    </p>
                    <p className="">
                        {data.farms}
                    </p>
                </div>
            <div className="flex justify-between text-xl text-green-dark">
                    <p className="">
                    <TankSVG className="inline-block -translate-y-[2px] p-[2px]" /> Tanks
                    </p>
                    <p className="">
                        {data.tanks}/{Number(data.farms)*8} 
                    </p>
                </div>
            <div className="flex justify-between text-xl text-yellow-dark">
                <p className="">
                    <LightSVG className="inline-block -translate-y-[2px] p-[2px]" /> Lux
                </p>
                <p className="">
                    {data.lux || 0}
                </p>
            </div>
            <div className="flex justify-between text-xl text-green-dark">
                    <p className="">
                    <TempSVG className="inline-block -translate-y-[2px]" /> Temperature
                    </p>
                    <p className="">
                        {data.temperature}
                    </p>
                </div>
        </div>
    )
}

export default ProductionSection;
