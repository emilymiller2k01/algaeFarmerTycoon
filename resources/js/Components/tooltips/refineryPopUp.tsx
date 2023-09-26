import React, { useState, useEffect } from 'react';
import { Modal } from '@mantine/core';
import { PageProps } from '/home/emily/code/algae/resources/js/types';
import { HomeProps, ByProductAssignments } from '/home/emily/code/algae/resources/js/Pages/Game';
import { router, usePage } from '@inertiajs/react';
import { Inertia } from '@inertiajs/inertia';

const RefineryPopUp = ({ handleClose, show }) => {
    const { refineries, byProductAssignments, initialGame } = usePage<PageProps<HomeProps>>().props as PageProps<HomeProps>;
    console.log("BALLS", byProductAssignments)
    const numberRefineries = refineries.length;

    const maxAssignments = numberRefineries;

    // Initialize assignments with initial values from byProductAssignments
    const initialAssignments = {
        biofuel: byProductAssignments.biofuel,
        antioxidants: byProductAssignments.antioxidants,
        food: byProductAssignments?.food,
        fertiliser: byProductAssignments?.fertiliser,
    };

    const [assignments, setAssignments] = useState<ByProductAssignments>(initialAssignments);

    function handleAssignmentChange(byproduct: string, newAssignments: number) {
        console.log("FACK")
        const currentAssignments = assignments[byproduct];

        if (newAssignments >= 0 && newAssignments <= maxAssignments) {
            const totalAssignments = Object.values(assignments).reduce((sum, value) => sum + value, 0);

            if (totalAssignments - currentAssignments + newAssignments <= maxAssignments) {
                const updatedAssignments = { ...assignments, [byproduct]: newAssignments };
                setAssignments(updatedAssignments);

                console.log("wagwan", updatedAssignments);

                router.post(`/game/${initialGame.id}/update-assignments`, {
                    assignments: updatedAssignments,
                }, {
                    onSuccess: () => {
                        router.reload({ only: ['RefineriesSection'] });
                    }
                });
            }
        }
    }

    console.log("AHHHH", initialAssignments)

    return (
        <Modal opened={show} onClose={handleClose} size="md" padding="md" withCloseButton>
            <div className="modal-main">
                <h2>Number of Available Refineries: {numberRefineries}</h2>
                <div className="assignment-column">
                    {Object.keys(initialAssignments).map((byproduct) => (
                        <AssignmentComponent
                            key={byproduct}
                            totalAssignments={maxAssignments}
                            byproduct={byproduct}
                            assignments={assignments[byproduct]}
                            onChangeFunc={(newAssignments: number) => handleAssignmentChange(byproduct, newAssignments)}
                        />
                    ))}
                </div>
                <button type="button" onClick={handleClose}>
                    Close
                </button>
                {/* Display the assignments */}
                
            </div>
        </Modal>
    );
};

const AssignmentComponent = ({ totalAssignments, byproduct, assignments, onChangeFunc }: AssignmentComponentProps) => {
    const handleIncrement = () => {
        console.log("INCREMENT", assignments)
        if (assignments < totalAssignments) {
            console.log("BALLS")
            onChangeFunc(assignments + 1);
        }
    };

    const handleDecrement = () => {
        console.log("DECREMENT")
        if (assignments > 0) {
            console.log("NO BALLS")
            onChangeFunc(assignments - 1);
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

type AssignmentComponentProps = {
    totalAssignments: number,
    byproduct: string,
    assignments: number,
    onChangeFunc: (val: number) => void
}

export default RefineryPopUp;
