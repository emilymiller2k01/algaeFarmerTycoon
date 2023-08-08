import React from 'react'
import ExpansionButton from "./ExpansionButton"

const ExpansionsSection = (props: ExpansionsProps) => {
    return (
        <div className="flex flex-col h-full">
            <div className="flex px-8 py-6 bg-grey items-start">
                <h1 className="text-2xl text-green font-semibold">
                    Expansions
                </h1>
            </div>
            <div className="flex flex-grow flex-col overflow-y-scroll">
                <div className="grid grid-cols-2 gap-y-[10px] gap-x-4 p-4">
                    <ExpansionButton title={"Florescent"} />
                    <ExpansionButton title={"LED"} />
                    <ExpansionButton title={"Refinery"} />
                    <ExpansionButton title={"Farm"} />
                    <ExpansionButton title={"CO2"} />
                    <ExpansionButton title={"Nutrients"} />
                    <ExpansionButton title={"Tank"} />
                </div>
            </div>


        </div>
    )
}

export default ExpansionsSection

export type ExpansionsProps = {

}