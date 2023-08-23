import React from 'react';
import { Tooltip, Text } from '@mantine/core';

const ExpansionButton = (props: ExpansionButtonProps) => {
    const tooltipContent = (
        <div style={{ maxWidth: '200px' }}>
            <Text align="center">{props.description}</Text>
            <hr />
            <Text align="center">{props.costs}</Text>
            <hr />
            <Text align="center">{props.benefits}</Text>
        </div>
    );

    return (
        <Tooltip content={tooltipContent} withArrow placement="top">
            <button
                style={{
                    background: 'black',
                    color: 'limegreen',
                    borderRadius: '10px',
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                    justifyContent: 'center',
                    transition: 'color 0.2s',
                    padding: '10px 15px',
                }}
                onClick={props.onClick}
                onMouseOver={() => (document.body.style.cursor = 'pointer')}
                onMouseOut={() => (document.body.style.cursor = 'default')}
            >
                <h1 style={{ fontSize: '1.5rem', margin: '5px 0' }}>
                    {props.title}
                </h1>
            </button>
        </Tooltip>
    );
};

export default ExpansionButton;

export type ExpansionButtonProps = {
    title: string;
    onClick?: () => void;
    description: string;
    costs: string;
    benefits: string;
};
