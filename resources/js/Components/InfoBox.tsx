import React from 'react';

const InfoBox = (props: InfoBoxProps) => {
    return (
        <div className="px-2 py-2 border border-green-dark w-full">
            <h2 className="text-2xl text-green font-semibold">
                {props.title}
            </h2>
            <p className="text-xl text-green-dark">
                {props.description}
            </p>
            {
                props.taskId && props.onCompleteTask &&
                <button
                    className="bg-green text-white px-4 py-2 mt-2 rounded"
                    onClick={() => props.onCompleteTask(props.taskId)}
                >
                    Complete Task
                </button>
            }
        </div>
    );
}

export default InfoBox;

export type InfoBoxProps = {
    title: string;
    description: string;
    taskId?: string; // this prop is optional, if provided, it shows the complete task button
    onCompleteTask?: (taskId: string) => void;
}
