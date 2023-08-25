import React, {useState} from 'react';
import {router, usePage} from "@inertiajs/react";
import { HomeProps } from '../Pages/Game'


const FarmSection = ({updateSelectedFarm }) => {

    const { productionData, initialGame, farms } = usePage<HomeProps>().props


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
        router.post(`/game/${initialGame.id}/selectFarm`, { farm_id: newFarmId }, {
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
                    className={`px-6 py-3 text-2xl hover:text-green hover:bg-grey-light text-left font-semibold rounded-lg ${initialGame.selected_farm_id === farm.id ? "active bg-grey-light text-green" : "bg-grey text-green-dark"}`}
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
