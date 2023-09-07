import React, {useState} from 'react'
import ExpansionButton from "./ExpansionButton"
import game, { GameProps } from "../Pages/Game";
import { InertiaLink } from '@inertiajs/inertia-react'
import axios from "axios";
import { HomeProps } from '../Pages/Game'
import { router, usePage } from '@inertiajs/react'


const ExpansionsSection = () => {

    const { productionData, initialGame } = usePage<HomeProps>().props

    //const hasResearchedRefinery = props.game.id.researchTasks.some(task => task.name === "Refinery");
    const [tanks, setTanks] = useState([]);


    const addFarm = () => {
        router.post(`/game/${initialGame.id}/farm/${initialGame.selected_farm_id}/addFarm`, {}, {
            onSuccess: () => {
                router.reload({ only: ['MultiSection', 'FarmSelection'] });
            }})

    };

    const addLight = (lightType: string) => {
        console.log("light added ", lightType);
        router.post(`/game/${initialGame.id}/farm/${initialGame.selected_farm_id}/light`, {
            lightType: lightType, // assuming the title is the type of light you want to add
        }, {
            onSuccess: () => {
                router.reload({ only: ['ProductionSection'] });
            }
        });
    };

    const addFarmCo2 = () => {
        router.post(`/game/${initialGame.id}/farm/${initialGame.selected_farm_id}/farmCo2`, {});
    };

    const addFarmNutrients = () => {
        router.post(`/game/${initialGame.id}/farm/${initialGame.selected_farm_id}/farmNutrients`, {});
    };


    const addFarmTank = () => {
        router.post(`/game/${initialGame.id}/farm/${initialGame.selected_farm_id}/addTank`, {},{
            onSuccess: () => {
                // Refresh only the parts of your UI you need to. In this case, we're assuming you have a 'TankSection'.
                router.reload({ only: ['TankContainer'] });
            }
        });
    }

    const harvestFarmAlgae = () => {
        router.get(`/game/${initialGame.id}/farm/${initialGame.selected_farm_id}/harvestAlgae`, {},{
            onSuccess: () => {
                // Refresh only the parts of your UI you need to. In this case, we're assuming you have a 'TankSection'.
                router.reload({ only: ['MultiSection', 'ProductionSection'] });
            }
        });
    }

    const addFarmRefinery = () => {
        router.post(`/game/${initialGame.id}/farm/${initialGame.selected_farm_id}/refinery`, {}, {
            onSuccess: () => {
                router.reload({only: ['refineries']})
            }
        });
    };

    const increaseTemp = () => {
        router.post(`/game/${initialGame.id}/farm/${initialGame.selected_farm_id}/increaseTemp`, {});
    };

    const decreaseTemp = () => {
        router.post(`/game/${initialGame.id}/farm/${initialGame.selected_farm_id}/decreaseTemp`, {});
    };

    return (
        <div className="flex flex-col h-full">
            <div className="flex px-8 py-6 bg-grey items-start">
                <h1 className="text-2xl text-green font-semibold">
                    Expansions
                </h1>
            </div>
            <div className="flex flex-grow flex-col overflow-y-scroll">
                <div className="grid grid-cols-2 gap-y-[10px] gap-x-4 p-4">
                    <ExpansionButton title={"Florescent"} onClick={() => { addLight("florescent")}} description='Florescent light is less expensive but provides fewer Lux and requires more MW.' costs={'Money: 10\nMW: 1'} benefits='Lux: +10'/>
                    <ExpansionButton title={"LED"} onClick={() => { addLight("led") }} description='LED light is more expensive but provides more Lux and requires less MW.' costs='Money: 20 MW: 0.5' benefits='Lux: +20'/>
                    {/*{props.game.researchedRefineries &&*/}
                    <ExpansionButton title={"Refinery"} onClick={() => { addFarmRefinery() }} description='Refineries process algae to make byproducts, which increase the profit per kg of algae' costs='Money: 200 MW: 2' benefits='+$50 per kg of algae harvested.'/>
                    <ExpansionButton title={"Farm"} onClick={() => { addFarm() }} description='Add a new farm to the game' costs='Money: 300 MW: 3' benefits='+8 tanks +4 refineries'/>
                    <ExpansionButton title={"CO2"} onClick={() => { addFarmCo2() }} description='Max out the CO2 supply to this farm' costs='Money: 50' benefits='100% saturation of CO2 reserves'/>
                    <ExpansionButton title={"Nutrients"} onClick={() => { addFarmNutrients() }} description='Max out the nutrient supply to this farm' costs='Money: 50' benefits='100% saturation of nutrient reserves'/>
                    <ExpansionButton title={"Tank"} onClick={() => { addFarmTank() }} description='Add a new tank to the farm' costs='Money: 60 MW: 1' benefits='Increased algae production'/>
                    <ExpansionButton title={"Harvest"} onClick={() => { harvestFarmAlgae()}} description='Harvest the farms algae' costs='' benefits='+$40 per kg of algae harvested'/>
                    <ExpansionButton title={"Increase Temperature"} onClick={() =>{increaseTemp()}} description='Increase the farms tank temperature' costs='-0.25 MW per degrees' benefits='+1 degree in farm temperature'/>
                    <ExpansionButton title={"Decrease Temperature"} onClick={() =>{decreaseTemp()}} description='Decrease the farms tank temperature' costs='+0.25 MW per degrees' benefits='-1 degree in farm temperature'/>
                </div>
            </div>
        </div>
    )
}



export default ExpansionsSection
