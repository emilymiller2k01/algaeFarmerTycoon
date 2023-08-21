// @ts-ignore
import { Head } from '@inertiajs/react';
import React, { useState } from "react";
import {router} from "@inertiajs/react";

export default function Dashboard({ auth, games }) {
    const [gameName, setGameName] = useState(''); // State to store the game name
    const [showModal, setShowModal] = useState(false); // State to show/hide the modal

    const openModal = () => setShowModal(true);
    const closeModal = () => setShowModal(false);

    // Handle game creation
    const handleNewGame = async () => {
        closeModal();

        if (!gameName) {
            console.error("Please enter a game name");
            return; // exit the function if no game name is provided
        }


        router.post('/game', {
            user_id: auth.id,
            name: gameName
        });


    };

    return (
        <div>
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>

            <Head title="Dashboard"/>

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div>Hello, {auth.name}</div>

                            <h3>Your Games</h3>
                            {games.length ? (
                                <ul>
                                    {games.map(game => (
                                        <li key={game.id}>
                                            <a href={`/game/${game.id}`}>{game.name}</a>
                                        </li>
                                    ))}
                                </ul>
                            ) : (
                                <div>No games available. Start a new game below!</div>
                            )}

                            <button onClick={openModal}>Start New Game</button>

                            {/* Modal for game name */}
                            {showModal && (
                                <div>
                                    <div>Please enter game name:</div>
                                    <input
                                        type="text"
                                        value={gameName}
                                        onChange={e => setGameName(e.target.value)}
                                    />
                                    <button onClick={handleNewGame}>Confirm</button>
                                    <button onClick={closeModal}>Cancel</button>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
