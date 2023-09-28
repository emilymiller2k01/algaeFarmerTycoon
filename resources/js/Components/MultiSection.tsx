import React, { useState, useEffect } from 'react';
import SettingsSVG from "./Icons/SettingsSVG";
import InfoBox from "./InfoBox";
import TankContainer from "./TankContainer";
import PowerSection from "./PowerSection";
import AutomationSection from "./AutomationSection";
import RefineriesSection from "./RefineriesSection";
import { HomeProps } from '../Pages/Game'
import { router, usePage} from '@inertiajs/react';
import { TankContext } from '../TankContext';


const MultiSection = () => {
    const { productionData, initialGame, researchTasks, tanks, powers} = usePage<HomeProps>().props
    const [currentTab, setCurrentTab] = useState(0);
    const automatedTasks = researchTasks.filter(task => task.automation && task.completed);
    const [isTask10Completed, setIsTask10Completed] = useState(researchTasks.some(task => task.title === "Adding Refineries" && task.completed));

    const handleCompleteTask = async (taskId: number, taskTitle: string) => {
        router.post(`/game/${initialGame.id}/research-tasks/complete/${taskId}`, {}, {
            onSuccess: () => {
                setIsTask10Completed(taskTitle === "Adding Refineries" || isTask10Completed);
                router.reload();
            }
        })
    };    

    return (
        <div className="flex flex-col h-full">
            {/* Tab Navigation */}
            <div className="flex bg-grey justify-between">
                {["Farm", "Research"].map((tab, index) => (
                    <button
                        key={index}
                        className={`text-2xl py-6 px-3 font-semibold w-full ${(currentTab === index) ? "text-green bg-grey" : "text-green-dark bg-grey-dark hover:text-green hover:bg-grey"}`}
                        onClick={() => setCurrentTab(index)}>
                        {tab}
                    </button>
                ))}
                <button
                    className={`text-2xl px-8 pt-1 font-semibold ${(currentTab === 3) ? "text-green bg-grey" : "text-green-dark bg-grey-dark hover:text-green hover:bg-grey"}`}
                    onClick={() => setCurrentTab(3)}>
                    <SettingsSVG />
                </button>
            </div>

            {/* Tab Content */}
            {(currentTab === 0) &&
                <div className=" py-4 h-full flex-grow flex flex-col bg-black">
                    <div className="flex flex-col gap-4 pb-20 px-4 flex-grow overflow-y-auto ">
                        <PowerSection />
                        <TankContext.Provider value={{tanks: tanks}}>
                            <TankContainer selectedFarmId={initialGame.selected_farm_id} />
                        </TankContext.Provider>
                        <AutomationSection game={initialGame} tasks={automatedTasks} />
                        {isTask10Completed && <RefineriesSection />}
                    </div>
                </div>
            }
            {(currentTab === 1) && (
                <div className="py-4 h-full flex-grow flex flex-col bg-black">
                    <h1 className="text-2xl text-green pb-4 px-4 font-semibold">Research</h1>
                    <div className="flex flex-col gap-4 pb-20 px-4 flex-grow overflow-y-auto ">
                        {researchTasks
                            .slice() // Create a copy of the array to avoid mutating the original array
                            .sort((a, b) => (a.completed ? 1 : -1)) // Sort completed tasks to the bottom
                            .map((task) => (
                                <div
                                    key={task.id}
                                    className="cursor-pointer"
                                >
                                    <InfoBox
                                        title={task.title}
                                        description={task.task}
                                        taskId={task.id}
                                        completed={task.completed}
                                        onCompleteTask={() => handleCompleteTask(task.id, task.title)}
                                        cost={task.cost}
                                        mw={task.mw}
                                    />
                                </div>
                            ))}
                    </div>
                </div>
            )}
            {(currentTab === 2) &&
                <div className="flex flex-col gap-4 py-6 px-8 flex-grow overflow-y-auto">
                    Settings
                </div>
            }
        </div>
    );
}

export default MultiSection;

