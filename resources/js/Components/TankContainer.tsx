import React, { useContext, useMemo } from 'react';
import Tank from './Tank';
import { HomeProps, LightType } from '../Pages/Game'; // Import HomeProps and LightType types
import { TankContext } from '../TankContext';
import { usePage } from '@inertiajs/react';

const TankContainer = ({ selectedFarmId }: TankContainerProps) => {
    const { tanks } = useContext(TankContext);
    const {farms, lights} = usePage<HomeProps>().props

    
    // Step 1: Get the Selected Farm
    const selectedFarm = farms.find(farm => farm.id === selectedFarmId);
    
    
    const led = useMemo(() => lights.filter((light) => light.type === "led").length, [lights]);
    const florescent = useMemo(() => lights.filter((light) => light.type === "florescent").length, [lights]);

    return (
        <div className="px-4 pb-4 pt-2 border-2 border-green-dark rounded-[10px] bg-transparent">
            <h1 className="text-2xl text-green font-semibold pb-2" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                <div>
                    Tanks - {tanks.length}/8
                </div>
                <div>
                    LEDs: {led}
                </div>
                <div>
                    Florescent: {florescent}
                </div>
            </h1>

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
