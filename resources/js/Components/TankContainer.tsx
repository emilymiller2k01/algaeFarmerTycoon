import React, {useEffect, useState} from 'react'
import Tank from "./Tank"
import {GameProps} from "../Pages/Game";

const TankContainer = (props: TankContainerProps) => {
    const [tanks, setTanks] = useState([]);

    useEffect(() => {
        (async () => {
            const fetchedTanks = getTanksByFarmId(props.game.selected_farm_id);
            setTanks(fetchedTanks);
        })();
    }, [props.game.selected_farm_id]);

    return (
        <div className="px-4 pb-4 pt-2 border-2 border-green-dark rounded-[10px] bg-transparent">
            <h1 className="text-2xl text-green font-semibold pb-2">
                Tanks - 4/10
            </h1>
            <div className="flex max-w-full flex-wrap gap-y-6 justify-evenly gap-x-4">
                {tanks.map(tank => (
                    <Tank key={tank.id} progress={tank.progress} />
                ))}
            </div>
        </div>
    )
}

const getTanksByFarmId = (farmId: number) => {
    // Return a mock array of tanks based on farmId
    return [
        { id: 1, progress: 40 },
        { id: 2, progress: 50 },
        // ... add more tanks
    ];
}

// const getTanksByFarmId = async (farmId: number): Promise<any[]> => {
//     try {
//         const response = await fetch(`https://your-api-endpoint.com/farms/${farmId}/tanks`);
//         if (!response.ok) {
//             throw new Error('Network response was not ok');
//         }
//         const tanks = await response.json();
//         return tanks;
//     } catch (error) {
//         console.error("There was a problem with the fetch operation:", error.message);
//         return [];
//     }
// };


export default TankContainer

export type TankContainerProps = {
    game: GameProps;
}
