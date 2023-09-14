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
import echo from '../echo';
import Echo from 'laravel-echo'

const listenForProductionDataUpdates = () => {
    echo.channel('production-data').listen('.ProductionDataUpdated', (event) => {
        // Handle the event data here and update your component's state
        const updatedProductionData = event.data; // Replace with your event data structure

        // Use the updatedProductionData to update your component's state or trigger a reload
        console.log('Production Data Updated:', updatedProductionData);
        
        // You can update your component's state here using useState if necessary
        // For example: setProductionData(updatedProductionData);
    });
};

const ProductionSection = (props: HomeProps) => {

    // const { productionData, initialGame } = props
      

    // const reloadData = () => {
    //     console.log('Prod data:');
    //     Object.keys(productionData).forEach(key => {
    //         console.log(`${key}: ${productionData[key]}`);
    //     });
    //     router.reload({
    //         only: ["productionData", "TankContainer"]
    //     })
    // }

    
    // const { start, stop } = useInterval(reloadData, 1000);

    // useEffect(() => {
    //     start();
    //     listenForProductionDataUpdates(); // Listen for events when the component mounts

    //     // Clean up the event listener when the component unmounts
    //     return () => {
    //         echo.leave('production-data'); // Leave the channel
    //     };
    // }, []);

    const { productionData, initialGame } = props;
    const [updatedProductionData, setUpdatedProductionData] = useState({});

    useEffect(() => {
        // Initialize Laravel Echo
        const echo = new Echo({
        broadcaster: 'pusher',
        key: 'your-push-key', // Replace with your Pusher key
        cluster: 'eu', // Replace with your cluster
        encrypted: true,
        });

        // Subscribe to the 'production-data' channel and listen for the 'ProductionDataUpdated' event
        echo.channel('production-data').listen('.ProductionDataUpdated', (event) => {
        // Handle the event data and update the component's state
        const updatedData = event.data; // Replace with your event data structure
        console.log('Production Data Updated:', updatedData);
        setUpdatedProductionData(updatedData);
        });

        // Clean up the event listener when the component unmounts
        return () => {
        echo.leave('production-data'); // Leave the channel
        };
    }, []);

    

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
                <p>{Number(updatedProductionData.moneyRate).toFixed(2)}</p>
            </div>

            <div className="flex justify-between text-xl text-green-dark">
                <p className="">
                    <AlgaeSVG className="inline-block -translate-y-[2px] p-[2px]" /> Algae Mass
                </p>
                <p className="">
                    {Number(updatedProductionData.algaeMass || 0).toFixed(2)}
                </p>
                <p>
                    {Number(updatedProductionData.algaeRate || 0).toFixed(2)}
                </p>
            </div>
            <div className="flex justify-between text-xl text-yellow-dark">
                <p className="">
                    <BubblesSVG className="inline-block -translate-y-[2px]" /> CO2
                </p>
                <p className="">
                    {Number(updatedProductionData.co2Amount || 0).toFixed(2)}%
                </p>
                <p>
                    {Number(productionData.co2Rate || 0).toFixed(2)}%
                </p>
            </div>
            <div className="flex justify-between text-xl text-green-dark">
                <p className="">
                    <TestTubeSVG className="inline-block -translate-y-[2px]" /> Nutrient 
                </p>
                <p>
                    {Number(updatedProductionData.nutrientsAmount).toFixed(2)}%
                </p>
                <p className="">
                    {Number(updatedProductionData.nutrientsRate || 0).toFixed(2)}%
                </p>

            </div>
            <div className="flex justify-between text-xl text-yellow-dark">
                    <p className="">
                    <FarmSVG className="inline-block -translate-y-[2px] p-[2px]" /> Farms
                    </p>
                    <p className="">
                        {updatedProductionData.farms}
                    </p>
                </div>
            <div className="flex justify-between text-xl text-green-dark">
                    <p className="">
                    <TankSVG className="inline-block -translate-y-[2px] p-[2px]" /> Tanks
                    </p>
                    <p className="">
                        {updatedProductionData.tanks}/{Number(updatedProductionData.farms)*8} 
                    </p>
                </div>
            <div className="flex justify-between text-xl text-yellow-dark">
                <p className="">
                    <LightSVG className="inline-block -translate-y-[2px] p-[2px]" /> Lux
                </p>
                <p className="">
                    {updatedProductionData.lux || 0}
                </p>
            </div>
            <div className="flex justify-between text-xl text-green-dark">
                    <p className="">
                    <TempSVG className="inline-block -translate-y-[2px]" /> Temperature
                    </p>
                    <p className="">
                        {updatedProductionData.temperature}
                    </p>
                </div>
        </div>
    )
}

export default ProductionSection;
