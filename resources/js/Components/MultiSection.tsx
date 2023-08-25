import React, { useState, useEffect } from 'react';
import SettingsSVG from "./Icons/SettingsSVG";
import { achievements, research } from "../data/props";
import InfoBox from "./InfoBox";
import Tank from "./Tank";
import TankContainer from "./TankContainer";
import PowerSection from "./PowerSection";
import AutomationSection from "./AutomationSection";
import RefineriesSection from "./RefineriesSection";
import { HomeProps } from '../Pages/Game'
import { router, usePage } from '@inertiajs/react';

const MultiSection = () => {
    const { productionData, initialGame, researchTasks} = usePage<HomeProps>().props
    const [currentTab, setCurrentTab] = useState(0);
    const [completedResearchTasks, setCompletedResearchTasks] = useState([]);
    const [completedAutomationTasks, setCompletedAutomationTasks] = useState([]);



    const handleCompleteTask = (taskID) => {
        return 1;
    }

    

    return (
        <div className="flex flex-col h-full">
            {/* Tab Navigation */}
            <div className="flex bg-grey justify-between">
                {["Farm", "Research", "Achievements"].map((tab, index) => (
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
                        <PowerSection game={initialGame} selectedFarmId={initialGame.selected_farm_id} expanded />
                        <TankContainer game={initialGame} selectedFarmId={initialGame.selected_farm_id} />
                        <AutomationSection game={initialGame} tasks={completedAutomationTasks} />
                        {
                            completedResearchTasks.some(task => task.name === "Refineries Research") &&
                            <RefineriesSection game={initialGame} />
                        }
                    </div>
                </div>
            }
            {(currentTab === 1) && (
                <div className="py-4 h-full flex-grow flex flex-col bg-black">
                    <h1 className="text-2xl text-green pb-4 px-4 font-semibold">Research</h1>
                    <div className="flex flex-col gap-4 pb-20 px-4 flex-grow overflow-y-auto ">
                                <pre className='text-white'>
                                    {JSON.stringify(researchTasks, null, 2)}
                                </pre>
                        {researchTasks.map((task) => (
                            <div
                                key={task.id}
                                className="cursor-pointer"
                                onClick={() => handleCompleteTask(task.id)}
                            >
                                <InfoBox
                                    title={task.title}
                                    description={task.task}
                                    taskId={task.id.toString()}
                                    onCompleteTask={handleCompleteTask}
                                />
                            </div>
                        ))}
                    </div>
                </div>
            )}

            {(currentTab === 2) &&
                <div className="py-4 h-full flex-grow flex flex-col bg-black">
                    <h1 className="text-2xl text-green pb-4 px-4 font-semibold">Achievements</h1>
                    <div className="flex flex-col gap-4 pb-20 px-4 flex-grow overflow-y-auto ">
                        {achievements.map((achievementItem, index) => {
                            return <InfoBox key={index} {...achievementItem} />
                        })}
                    </div>
                </div>
            }
            {(currentTab === 3) &&
                <div className="flex flex-col gap-4 py-6 px-8 flex-grow overflow-y-auto">
                    Settings
                </div>
            }
        </div>
    );
}

export default MultiSection;

