import React, {useState} from 'react';
import {GameProps, Tank} from "../Pages/Game";
import {router, usePage} from "@inertiajs/react";

type Farm = {
    id: number;
    tanks: Tank[];
    mw: number;
}

type FarmSectionProps = {
    game: GameProps;
    selectedFarmId: number;
    updateSelectedFarm?: (farmId: number) => void; // Callback function
};

const FarmSection: React.FC<FarmSectionProps> = ({ game, selectedFarmId, updateSelectedFarm }) => {
    // Fetch farms from usePage
    const {farms} = usePage<{farms: Farm[]}>().props;
    //const [selectedFarm] = useState([]);
    console.log(farms)

    // const handleFarmChange = (newFarmId) => {
    //     router.post(`/game/${game.id}/selectFarm`, { farm_id: newFarmId }, {
    //         onSuccess: () => {
    //             router.reload({ only: ['MultiSection'] });
    //         }
    //     });
    // }

    const handleFarmChange = (newFarmId) => {
        router.post(`/game/${game.id}/selectFarm`, { farm_id: newFarmId }, {
            onSuccess: () => {
                // This will update the local state of the component
                updateSelectedFarm(newFarmId);
            }
        });
    };


    return (
        <div>
            {Array.isArray(farms) && farms.map(farm => (
                <button
                    className={`px-6 py-3 text-2xl hover:text-green hover:bg-grey-light text-left font-semibold rounded-lg ${selectedFarmId === farm.id ? "active bg-grey-light text-green" : "bg-grey text-green-dark"}`}
                    key={farm.id}
                    onClick={() => handleFarmChange(farm.id)}
                >
                    {`Farm ${farm.id}`}
                </button>
            ))}
        </div>
    );
}

export default FarmSection;
