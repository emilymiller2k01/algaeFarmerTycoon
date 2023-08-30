import React from 'react';

const InfoBox = (props: InfoBoxProps) => {
    return (
        <div className="px-2 py-2 border border-green-dark w-full" onClick={() => props.onCompleteTask(props.taskId)}>
            <h2 className="text-2xl text-green font-semibold">
                {props.title}
            </h2>
            <p className="text-xl text-green-dark">
                {props.description}
            </p>
        </div>

    );
}

export default InfoBox;

export type InfoBoxProps = {
    title: string;
    description: string;
    taskId?: Number; 
    onCompleteTask?: (taskId: Number) => void;
}
