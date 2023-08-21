import React from 'react';
import Tooltip from '@mui/material/Tooltip';

const ExpansionButton = (props: ExpansionButtonProps) => {

    const tooltipContent = (
        <div style={{
            padding: '8px',
            border: '1px solid limegreen',
            borderRadius: '8px',
            backgroundColor: 'black',
            boxShadow: 'red',
            color: 'limegreen',
            backdropFilter: 'none'
        }}>
            <div>{props.description}</div>
            <hr style={{ borderColor: 'limegreen' }} />
            <div>Costs: {props.costs}</div>
            <hr style={{ borderColor: 'limegreen' }} />
            <div>Benefits: {props.benefits}</div>
        </div>
    );

    return (
        <Tooltip title={tooltipContent} arrow sx={{
            "& .MuiTooltip-tooltip": {
                backgroundColor: 'black',
                color: 'limegreen',
                fontSize: '0.8rem',
                borderRadius: '8px',
                backdropFilter: 'none'

            },
            "& .MuiTooltip-arrow": {
                color: 'black'
            }
        }}>
            <button
                className="flex flex-col items-center justify-center text-green-dark hover:text-green rounded-md"
                onClick={props.onClick}>
                <h1 className="text-2xl text-center p-2">
                    {props.title}
                </h1>
            </button>
        </Tooltip>
    );
}

export default ExpansionButton;

export type ExpansionButtonProps = {
    title: string;
    onClick?: () => void;
    description: string;
    costs: string;
    benefits: string;
}
