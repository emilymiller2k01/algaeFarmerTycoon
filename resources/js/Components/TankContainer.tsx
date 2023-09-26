import React, { useContext } from 'react';
import Tank from './Tank';
import { HomeProps, LightType } from '../Pages/Game'; // Import HomeProps and LightType types
import { TankContext } from '../TankContext';
import { usePage } from '@inertiajs/react';

const TankContainer = ({ selectedFarmId }: TankContainerProps) => {
    const { tanks } = useContext(TankContext);
    const {farms} = usePage<HomeProps>().props

    // // Step 1: Get the Selected Farm
    // const selectedFarm = farms.find(farm => farm.id === selectedFarmId);

    // console.log(selectedFarm);

    // // Step 2: Access the Lights for the Selected Farm
    // const lights: LightType[] = selectedFarm ? selectedFarm.lights : [];


    // // Step 3: Count the Lights
    // const ledLightsCount = lights.filter(light => light === LightType.led).length;
    // const fluorescentLightsCount = lights.filter(light => light === LightType.florescent).length;

    return (
        <div className="px-4 pb-4 pt-2 border-2 border-green-dark rounded-[10px] bg-transparent">
            <h1 className="text-2xl text-green font-semibold pb-2">
                Tanks - {tanks.length}/8
            </h1>

            {/* Step 4: Display the Counts in the Component
            <div className="text-green font-semibold">
                LED Lights: {ledLightsCount}
            </div>
            <div className="text-green font-semibold">
                Fluorescent Lights: {fluorescentLightsCount}
            </div> */}

            <div className="flex max-w-full flex-wrap gap-y-6 justify-evenly gap-x-4">
                {Array.isArray(tanks) && tanks.map(tank => (
                    <Tank key={tank.id} {...tank} />
                ))}
            </div>
        </div>
    );
};

type TankContainerProps = { 
    selectedFarmId: number;
};

export default TankContainer;
