import React, { useState } from 'react';
import { Modal } from '@mantine/core';
import { PageProps } from '/home/emily/code/algae/resources/js/types';
import { HomeProps } from '/home/emily/code/algae/resources/js/Pages/Game';
import { router, usePage } from '@inertiajs/react';

type ByproductAssignments = {
    byproduct1: number;
    byproduct2: number;
    byproduct3: number;
    byproduct4: number;
};

const RefineryPopUp = ({ handleClose, show }) => {
    const { refineries } = usePage<PageProps<HomeProps>>().props;
    const numberRefineries = refineries.length;

    const maxAssignments = numberRefineries;

    const initialAssignments: ByproductAssignments = {
        byproduct1: 0,
        byproduct2: 0,
        byproduct3: 0,
        byproduct4: 0,
    };

    const [byproductAssignments, setByproductAssignments] = useState<ByproductAssignments>(initialAssignments);

    function handleAssignmentChange(byproduct: string, newAssignments: number) {
        const currentAssignments = byproductAssignments[byproduct];

        if (newAssignments >= 0 && newAssignments <= maxAssignments) {
            const totalAssignments = Object.values(byproductAssignments).reduce((sum, value) => sum + value, 0);
            
            if (totalAssignments - currentAssignments + newAssignments <= maxAssignments) {
                const updatedAssignments = { ...byproductAssignments, [byproduct]: newAssignments };
                setByproductAssignments(updatedAssignments);
            }
        }
    }

    return (
        <Modal
            opened={show}
            onClose={handleClose}
            size="md"
            padding="md"
            withCloseButton
        >
            <div className="modal-main">
                <h2>Number of Available Refineries: {numberRefineries}</h2>
                <div className="assignment-column">
                    {Object.keys(initialAssignments).map((byproduct) => (
                        <AssignmentComponent
                            key={byproduct}
                            totalAssignments={maxAssignments}
                            byproduct={byproduct}
                            assignments={byproductAssignments[byproduct]}
                            onChange={(newAssignments) => handleAssignmentChange(byproduct, newAssignments)}
                        />
                    ))}
                </div>
                <button type="button" onClick={handleClose}>
                    Close
                </button>
            </div>
        </Modal>
    );
};

const AssignmentComponent = ({ totalAssignments, byproduct, assignments, onChange }) => {
    const handleIncrement = () => {
        if (assignments < totalAssignments) {
            onChange(assignments + 1);
        }
    };

    const handleDecrement = () => {
        if (assignments > 0) {
            onChange(assignments - 1);
        }
    };

    return (
        <div>
            <button onClick={handleDecrement}>{"<"}</button>
            {assignments} for {byproduct}
            <button onClick={handleIncrement}>{">"}</button>
        </div>
    );
};

export default RefineryPopUp;
