import React from 'react'

const LogSection = (props: LogProps) => {
    return (
        <div className="flex flex-col h-full">
            <div className="flex px-8 py-6 bg-grey  justify-between font-semibold">
                <h1 className="text-2xl text-green">
                    Message Log
                </h1>
                <h2 className="text-2xl text-green-dark">
                    Clear
                </h2>
            </div>
            <div className="flex flex-col px-8 py-6 gap-2 flex-grow overflow-y-auto">
                {props.logs.map((log, index) => {
                    {return <p key={index} className="text-base text-white/60 font-semibold">{log}</p>}
                })}
            </div>
            

        </div>
    )
}

export default LogSection

export type LogProps = {
    logs: string[]
}