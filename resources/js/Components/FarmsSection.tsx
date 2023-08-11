import React, {useEffect, useState} from 'react'
import FarmButton from "./FarmButton"
import {GameProps} from "../Pages/Game";

const FarmsSection = (props: FarmsProps) => {
    const [farms, setFarms] = useState<Farm[]>([]);
    const [selectedFarm, setSelectedFarm] = useState<number | null>(props.game.selected_farm_id);


    useEffect(() => {
        // Mock fetch function, replace with your actual API call
        fetchFarmsByGameId(props.game.id).then(data => {
            setFarms(data);
        });
    }, [props.game.id]);

    return (
        <div className="flex flex-col h-full">
            <div className="flex px-8 py-6 bg-grey items-start">
                <h1 className="text-2xl text-green font-semibold">
                    Farms
                </h1>
            </div>
            <div className="flex flex-col gap-4 py-6 px-8 flex-grow overflow-y-auto">
                {farms.map(farm => (
                    <FarmButton
                        key={farm.id}
                        title={"Farm " + farm.id}
                        selected={farm.id === selectedFarm}
                        onClick={() => setSelectedFarm(farm.id)}
                    />
                ))}
            </div>
        </div>
    )
}

const fetchFarmsByGameId = async (gameId: number): Promise<Farm[]> => {
    const response = await fetch(`http://localhost:8000.com/game/{game_id}/farm/list`);

    // Error handling for non-200 status codes
    if (!response.ok) {
        throw new Error(`Failed to fetch farms for game ID: ${gameId}. Status: ${response.status}`);
    }

    const data: Farm[] = await response.json();
    return data;
}

export default FarmsSection

export type FarmsProps = {
    game: GameProps;
}

type Farm = {
    id: number;
}
