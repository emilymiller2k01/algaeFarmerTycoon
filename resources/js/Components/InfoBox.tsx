import React from 'react';

import { Tooltip, Text } from '@mantine/core';

const InfoBox = (props: InfoBoxProps) => {
    const tooltipContent = (
        <div style={{ 
            maxWidth: '200px', 
            whiteSpace: 'normal',
        }}>
            <Text align="center">Task: {props.title}</Text>
            <hr />
            <Text align="center">Cost: {(props.cost).toString()}</Text>
            <hr />
            <Text align="center">Required MW: {(props.mw).toString()}</Text>
        </div>
    );

    return (
        <Tooltip 
            label={tooltipContent} 
            withArrow 
            position="top"
            style={{
                background: 'black',
                color: 'limegreen',
                borderRadius: '10px',
                display: 'flex',
                flexDirection: 'column',
                alignItems: 'center',
                justifyContent: 'center',
                transition: 'color 0.2s',
                maxWidth: '200px',
                padding: '10px 15px',
            }}
        >
            <div
                className={`px-2 py-2 border w-full ${
                    props.completed ? 'border-yellow-dark' : 'border-green-dark'
                } ${
                    props.completed ? 'text-yellow' : ''
                }`}
                onClick={() => props.onCompleteTask?.(props.taskId)}
                onMouseOver={() => (document.body.style.cursor = 'pointer')}
                onMouseOut={() => (document.body.style.cursor = 'default')}
                style={{ cursor: 'pointer' }} // Apply cursor style directly
            >
                <h2 className={`text-2xl ${props.completed ? 'text-yellow' : 'text-green'} font-semibold`}>
                {props.title}
                </h2>
                <p className={`text-xl ${props.completed ? 'text-yellow-dark' : 'text-green-dark'}`}>
                    {props.description}
                </p>
            </div>
        </Tooltip>
    );
};

export default InfoBox;

export type InfoBoxProps = {
    title: string;
    description: string;
    taskId?: Number; 
    completed: Boolean;
    onCompleteTask?: (taskId: Number) => void;
    cost: Number;
    mw: Number;
}
