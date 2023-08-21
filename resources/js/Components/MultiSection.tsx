import React, { useState, useEffect } from 'react';
import SettingsSVG from "./Icons/SettingsSVG";
import { achievements, research } from "../data/props";
import InfoBox from "./InfoBox";
import Tank from "./Tank";
import TankContainer from "./TankContainer";
import PowerSection from "./PowerSection";
import AutomationSection from "./AutomationSection";
import RefineriesSection from "./RefineriesSection";
import { GameProps } from "../Pages/Game";

const MultiSection = (props: MultiProps) => {
    const { game, selectedFarmId } = props;
    const [currentTab, setCurrentTab] = useState(0);
    const [completedResearchTasks, setCompletedResearchTasks] = useState([]);
    const [completedAutomationTasks, setCompletedAutomationTasks] = useState([]);

    useEffect(() => {
        fetch('/research-tasks/completed/${game.id}')
            .then(response => response.json())
            .then(data => setCompletedResearchTasks(data));
    }, []);

    useEffect(() => {
        fetch('/research-tasks/completed-automation/${game.id}')
            .then(response => response.json())
            .then(data => setCompletedAutomationTasks(data));
    }, []);


    const handleCompleteTask = (taskId) => {
        fetch(`/api/research-tasks/complete/${taskId}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
        })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    fetch('/api/research-tasks/completed')
                        .then(response => response.json())
                        .then(data => setCompletedResearchTasks(data));
                }
            });
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
                        <PowerSection game={game} selectedFarmId={selectedFarmId} expanded />
                        <TankContainer game={game} selectedFarmId={selectedFarmId} />
                        <AutomationSection game={props.game} tasks={completedAutomationTasks} />
                        {
                            completedResearchTasks.some(task => task.name === "Refineries Research") &&
                            <RefineriesSection game={props.game} />
                        }
                    </div>
                </div>
            }
            {(currentTab === 1) &&
                <div className="py-4 h-full flex-grow flex flex-col bg-black">
                    <h1 className="text-2xl text-green pb-4 px-4 font-semibold">Research</h1>
                    <div className="flex flex-col gap-4 pb-20 px-4 flex-grow overflow-y-auto ">
                        {research.map((researchItem, index) => {
                            return <InfoBox key={index} {...researchItem} onCompleteTask={handleCompleteTask} />
                        })}
                    </div>
                </div>
            }
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
export type MultiProps = {
    game: GameProps;
    selectedFarmId: number;
}
