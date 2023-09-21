import React, { useEffect, useState } from 'react';
import { PageProps, Tank } from '../types';
import { useInterval } from '@mantine/hooks';
import { HomeProps } from '../Pages/Game';
import { usePage } from '@inertiajs/react';

type TankProps = Pick<Tank, "id" | "biomass" | "co2_level" | "nutrient_level">

const TankComponent = ({ id, biomass, co2_level, nutrient_level }: TankProps) => {

    const {tanks, initialGame} = usePage<PageProps<HomeProps>>().props;
    const tank = tanks.find(t => t.id === id);

    const [data, setData] = useState<Tank>(tank);

    const reloadData = async () => {
      try {
        //get the tank props to reload every second  
        fetch(`/game/${initialGame.id}/tank/${id}`).then((response) => {
            console.log(response);
            response.json().then(({tank: newData}) => {
                console.log("newdata", newData);
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

    //this only shows when the tank is manually reloaded 
    console.log(
        biomass/10,
        nutrient_level,
        co2_level,
    )

    return (
        <div className="relative">
            <div className="absolute top-[15px] left-0 p-2 flex flex-col justify-end h-[120px] w-[200px] gap-2">
                <div className="h-full w-full rounded-full border overflow-hidden bg-grey-light border-green-dark text-green relative items-center justify-center">
                    <div className="h-full bg-green-dark absolute left-0 items-center justify-center" style={{ width: `${(data.biomass /10)}%`, borderRadius: '0 5px 5px 0' }}>
                    </div>
                    <span className="w-full text-center text-green z-10 absolute left-0">Biomass</span>
                </div>
                <div className="h-full w-full rounded-full border overflow-hidden bg-grey-light border-green-dark text-green relative items-center justify-center">
                    <div className="h-full bg-yellow absolute left-0 z-0" style={{ width: `${data.nutrient_level}%`, borderRadius: '0 5px 5px 0' }}>
                    </div>
                        <span className="w-full text-center text-green z-10 absolute left-0">Nutrients</span>
                </div>
                <div className="h-full w-full rounded-full border relative overflow-hidden bg-grey-light border-green-dark text-green items-center justify-center">
                    <div className="h-full bg-yellow absolute left-0 items-center justify-center " style={{ width: `${data.co2_level}%`, padding: '0 5px', borderRadius: '0 5px 5px 0' }}>
                    </div>
                    <span className="w-full text-center text-green z-10 absolute left-0">CO2</span>
                </div>
            </div>
            <svg width="220" height="135" xmlns="http://www.w3.org/2000/svg">
                <polygon points="0,15 0,135 200,135 200,15" style={{ fill: "transparent", stroke: '#42FF00', strokeWidth: 2 }} />
                <line x1="0" y1="15" x2="20" y2="0" style={{ stroke: '#42FF00', strokeWidth: 2 }} />
                <line x1="200" y1="15" x2="220" y2="0" style={{ stroke: '#42FF00', strokeWidth: 2 }} />
                <line x1="200" y1="135" x2="220" y2="120" style={{ stroke: '#42FF00', strokeWidth: 2 }} />
                <line x1="20" y1="0" x2="220" y2="0" style={{ stroke: '#42FF00', strokeWidth: 2 }} />
                <line x1="220" y1="0" x2="220" y2="120" style={{ stroke: '#42FF00', strokeWidth: 2 }} />
            </svg>
        </div>
    );
};

export default TankComponent;
