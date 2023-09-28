import React, { useState } from 'react';
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
        const currentAssignments = assignments[byproduct];

        if (newAssignments >= 0 && newAssignments <= maxAssignments) {
            const totalAssignments = Object.values(assignments).reduce((sum, value) => sum + value, 0);

            if (totalAssignments - currentAssignments + newAssignments <= maxAssignments) {
                const updatedAssignments = { ...assignments, [byproduct]: newAssignments };
                setAssignments(updatedAssignments);

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

    return (
        <Modal
            opened={show}
            onClose={handleClose}
            size="md"
            padding="md"
            withCloseButton
            className="popup-modal" // Added a custom class for styling
        >
            <div className="modal-main">
                <h2 className="text-2xl text-center text-green mb-4">Number of Available Refineries: {numberRefineries}</h2> {/* Changed text-4xl to text-3xl */}
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
                <button
                    type="button"
                    onClick={handleClose}
                    className="text-lg text-green border border-green p-2 rounded-lg mt-4 absolute bottom-4 right-4" // Position the close button
                >
                    Close
                </button>
                {/* Display the assignments */}
            </div>
        </Modal>
    );
};

const AssignmentComponent = ({ totalAssignments, byproduct, assignments, onChangeFunc }: AssignmentComponentProps) => {
    const handleIncrement = () => {
        if (assignments < totalAssignments) {
            onChangeFunc(assignments + 1);
        }
    };

    const handleDecrement = () => {
        if (assignments > 0) {
            onChangeFunc(assignments - 1);
        }
    };

    return (
        <div className="flex items-center justify-center mb-4">
            <button
                onClick={handleDecrement}
                className="text-2xl text-green bg-white border border-green px-2 py-1 rounded-full" // Styled the arrows
            >
                {"<"}
            </button>
            <span className="text-lg text-green mx-2">{assignments} for {byproduct}</span>
            <button
                onClick={handleIncrement}
                className="text-2xl text-green bg-white border border-green px-2 py-1 rounded-full" // Styled the arrows
            >
                {">"}
            </button>
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
