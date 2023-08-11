import React from 'react'
import { useState } from "react";
import SettingsSVG from "./Icons/SettingsSVG";
import { achievements, research } from "../data/props";
import InfoBox from "./InfoBox";
import Tank from "./Tank";
import TankContainer from "./TankContainer";
import PowerSection from "./PowerSection";
import AutomationSection from "./AutomationSection";
import RefineriesSection from "./RefineriesSection";
import {GameProps} from "../Pages/Game";

const MultiSection = (props: MultiProps) => {
    const [currentTab, setCurrentTab] = useState(0);
    const tabs: String[] = ["Farm", "Research", "Achievements", "Settings"];
    return (
        <div className="flex flex-col h-full">
            <div className="flex bg-grey justify-between">
                <button className={`text-2xl py-6 px-3 font-semibold w-full ${(currentTab == 0) ? "text-green bg-grey" : "text-green-dark bg-grey-dark hover:text-green hover:bg-grey"}`} onClick={() => setCurrentTab(0)}>
                    Farm
                </button>
                <button className={`text-2xl py-6 px-3 font-semibold w-full ${(currentTab == 1) ? "text-green bg-grey" : "text-green-dark bg-grey-dark hover:text-green hover:bg-grey"}`} onClick={() => setCurrentTab(1)}>
                    Research
                </button>
                <button className={`text-2xl py-6 px-3 font-semibold w-full ${(currentTab == 2) ? "text-green bg-grey" : "text-green-dark bg-grey-dark hover:text-green hover:bg-grey"}`} onClick={() => setCurrentTab(2)}>
                    Achievements
                </button>
                <button className={`text-2xl  px-8 pt-1 font-semibold  ${(currentTab == 3) ? "text-green bg-grey" : "text-green-dark bg-grey-dark hover:text-green hover:bg-grey"}`} onClick={() => setCurrentTab(3)}>
                    <SettingsSVG />
                </button>
            </div>
            {(currentTab == 0) ?
                //Farm
                <div className=" py-4 h-full flex-grow flex flex-col bg-black">
                    <div className="flex flex-col gap-4 pb-20 px-4 flex-grow overflow-y-auto ">
                        <PowerSection game={props.game} expanded />
                        <TankContainer game={props.game} />
                        <AutomationSection game={props.game} />
                        <RefineriesSection game={props.game} />
                    </div>

                </div>
                : (currentTab == 1) ?
                    //Research
                    <div className=" py-4 h-full flex-grow flex flex-col bg-black">
                        <h1 className="text-2xl text-green pb-4 px-4 font-semibold">
                            Research
                        </h1>
                        <div className="flex flex-col gap-4 pb-20 px-4 flex-grow overflow-y-auto ">
                            {research.map((research, index) => {
                                return <InfoBox key={index} {...research} />
                            })}
                        </div>
                    </div>
                    : (currentTab == 2) ?
                        //Achievements
                        <div className=" py-4 h-full flex-grow flex flex-col bg-black">
                            <h1 className="text-2xl text-green pb-4 px-4 font-semibold">
                                Achievements
                            </h1>
                            <div className="flex flex-col gap-4 pb-20 px-4 flex-grow overflow-y-auto ">
                                {achievements.map((achievements, index) => {
                                    return <InfoBox key={index} {...achievements} />
                                })}
                            </div>
                        </div>
                        :
                        //Settings
                        <div className="flex flex-col gap-4 py-6 px-8 flex-grow overflow-y-auto">
                            Settings
                        </div>
            }
        </div>
    )
}

export default MultiSection

export type MultiProps = {
    game: GameProps;
}
